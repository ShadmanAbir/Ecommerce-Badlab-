<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Events\OrderPlaced;
use App\Events\StockLow;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function createOrder($orderData, $cartItems, $totals)
    {
        if ($cartItems->isEmpty()) {
            throw new \Exception('Your cart is empty');
        }

        $order = DB::transaction(function () use ($orderData, $cartItems, $totals) {
            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . time() . '-' . auth()->id(),
                'subtotal' => $totals['subtotal'],
                'discount_amount' => $totals['discount_amount'] ?? 0,
                'vat_amount' => $totals['vat_amount'] ?? 0,
                'shipping_amount' => $totals['shipping_amount'] ?? 0,
                'total_amount' => $totals['payable_amount'],
                'payment_method' => $orderData['payment_method'],
                'payment_status' => 'pending',
                'status' => 'pending',
                'shipping_address_id' => $orderData['shipping_address_id'] ?? null,
                'notes' => $orderData['notes'] ?? null,
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                // Determine price: variant price or product discounted price
                if ($cartItem->product_variant_id && $cartItem->variant) {
                    $price = $cartItem->variant->getDiscountedPrice();
                } else {
                    $price = $cartItem->product->getDiscountedPrice();
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_variant_id' => $cartItem->product_variant_id ?? null,
                    'product_stock_id' => $cartItem->product_stock_id ?? null,
                    'quantity' => $cartItem->quantity,
                    'size' => $cartItem->size,
                    'color' => $cartItem->color,
                    'price' => $price,
                    'subtotal' => $price * $cartItem->quantity,
                    'total' => $price * $cartItem->quantity,
                ]);

                // Update stock
                if ($cartItem->product_variant_id && $cartItem->variant) {
                    // Variant stock
                    $cartItem->variant->decrement('stock', $cartItem->quantity);
                    if ($cartItem->variant->fresh()->stock <= 5) {
                        event(new StockLow($cartItem->product));
                    }
                } elseif ($cartItem->product_stock_id) {
                    // Batch stock
                    $stock = \App\Models\ProductStock::find($cartItem->product_stock_id);
                    if ($stock) {
                        $stock->decrement('quantity', $cartItem->quantity);
                    }
                } else {
                    // Plain product stock
                    $cartItem->product->decrement('stock', $cartItem->quantity);
                    if ($cartItem->product->fresh()->stock <= 5) {
                        event(new StockLow($cartItem->product));
                    }
                }
            }

            // Clear cart
            if (auth()->check()) {
                Cart::where('user_id', auth()->id())->delete();
            }

            return $order;
        });

        // Dispatch event after transaction commits
        event(new OrderPlaced($order));

        return $order;
    }

    public function getUserOrders($userId)
    {
        return Order::with(['items.product.images', 'items.variant', 'payment', 'shippingAddress'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getOrderById($orderId)
    {
        return Order::with(['items.product.images', 'items.variant', 'payment', 'shippingAddress', 'user'])
            ->findOrFail($orderId);
    }

    /**
     * Cancel an order and restore stock
     */
    public function cancelOrder(Order $order, int $userId)
    {
        // Verify ownership
        if ($order->user_id !== $userId) {
            throw new \Exception('Unauthorized');
        }

        // Only pending/processing orders can be cancelled
        if (!in_array($order->status, ['pending', 'processing'])) {
            throw new \Exception('Only pending or processing orders can be cancelled.');
        }

        return DB::transaction(function () use ($order) {
            // Restore stock for each item
            foreach ($order->items as $item) {
                if ($item->product_variant_id) {
                    $variant = ProductVariant::find($item->product_variant_id);
                    if ($variant) {
                        $variant->increment('stock', $item->quantity);
                    }
                } elseif ($item->product_stock_id) {
                    $stock = \App\Models\ProductStock::find($item->product_stock_id);
                    if ($stock) {
                        $stock->increment('quantity', $item->quantity);
                    }
                } else {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->increment('stock', $item->quantity);
                    }
                }
            }

            // Update order status
            $order->update([
                'status' => 'cancelled',
                'payment_status' => $order->payment_status === 'paid' ? 'refunded' : $order->payment_status,
            ]);

            return $order->fresh();
        });
    }
}
