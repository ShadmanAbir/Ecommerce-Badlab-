<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function getCart()
    {
        $user = auth()->user();

        if (!$user) {
            return collect([]);
        }

        $query = Cart::with(['product.images', 'variant', 'productStock'])
            ->where('user_id', $user->id);

        return $query->get();
    }

    public function addToCart($productId, $quantity = 1, $size = null, $color = null, $stockId = null, $variantId = null)
    {
        $product = Product::findOrFail($productId);

        if (!auth()->check()) {
            throw new \Exception('Please login to add items to cart');
        }

        // Determine price: variant price or product discounted price
        $price = $product->getDiscountedPrice();
        if ($variantId) {
            $variant = ProductVariant::where('id', $variantId)
                ->where('product_id', $productId)
                ->where('is_active', true)
                ->first();

            if ($variant) {
                $price = $variant->getDiscountedPrice();
            }
        }

        $data = [
            'product_id' => $productId,
            'product_variant_id' => $variantId,
            'product_stock_id' => $stockId,
            'quantity' => $quantity,
            'size' => $size,
            'color' => $color,
            'user_id' => auth()->id(),
            'price' => $price,
        ];

        // Check for existing cart item with same product + variant + size + color
        $cart = Cart::where([
            'user_id' => auth()->id(),
            'product_id' => $productId,
            'product_variant_id' => $variantId,
            'product_stock_id' => $stockId,
            'size' => $size,
            'color' => $color,
        ])->first();

        if ($cart) {
            $cart->increment('quantity', $quantity);
            return $cart;
        }

        return Cart::create($data);
    }

    public function updateCart($cartId, $quantity)
    {
        $cart = Cart::where('id', $cartId)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        $cart->update(['quantity' => $quantity]);
        return $cart;
    }

    public function removeFromCart($cartId)
    {
        $cart = Cart::where('id', $cartId)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        $cart->delete();
        return true;
    }

    public function calculateTotals($cartItems)
    {
        $subtotal = 0;
        $discount = 0;

        foreach ($cartItems as $item) {
            // Use variant price if available, otherwise product price
            if ($item->variant) {
                $itemPrice = $item->variant->getDiscountedPrice();
            } else {
                $itemPrice = $item->product->getDiscountedPrice();
            }
            $itemTotal = $itemPrice * $item->quantity;
            $subtotal += $itemTotal;
        }

        $subtotalAfterDiscount = $subtotal - $discount;
        $vat = round($subtotalAfterDiscount * 0.05); // 5% VAT
        $shipping = 0; // Can be calculated later
        $payable = round($subtotalAfterDiscount + $vat + $shipping);

        return [
            'subtotal' => $subtotal,
            'discount_amount' => $discount,
            'vat_amount' => $vat,
            'shipping_amount' => $shipping,
            'payable_amount' => $payable,
        ];
    }

    public function getCartCount(): int
    {
        $user = auth()->user();
        if (!$user) {
            return 0;
        }

        return Cart::where('user_id', $user->id)->sum('quantity');
    }
}
