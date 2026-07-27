@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="bg-[#111111] min-h-screen">
    <div class="max-w-5xl mx-auto px-4 py-12">
        <a href="{{ route('user.orders') }}" class="inline-flex items-center text-white/40 hover:text-accent transition text-sm mb-6">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Orders
        </a>

        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-heading tracking-wider text-white">ORDER <span class="text-accent">{{ $order->order_number }}</span></h1>
                <p class="text-white/40 text-sm mt-1">{{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
            </div>
            <div class="mt-4 md:mt-0 flex gap-3">
                <span class="px-4 py-2 text-xs font-bold uppercase tracking-wider border
                    @if($order->status === 'delivered') text-green-400 border-green-400/30
                    @elseif($order->status === 'cancelled') text-red-400 border-red-400/30
                    @elseif($order->status === 'processing') text-blue-400 border-blue-400/30
                    @elseif($order->status === 'shipped') text-purple-400 border-purple-400/30
                    @else text-yellow-400 border-yellow-400/30 @endif">
                    {{ $order->status }}
                </span>
                <span class="px-4 py-2 text-xs font-bold uppercase tracking-wider border
                    @if($order->payment_status === 'paid') text-green-400 border-green-400/30
                    @elseif($order->payment_status === 'failed') text-red-400 border-red-400/30
                    @elseif($order->payment_status === 'refunded') text-purple-400 border-purple-400/30
                    @else text-yellow-400 border-yellow-400/30 @endif">
                    {{ $order->payment_status }}
                </span>
                @if(in_array($order->status, ['pending', 'processing']))
                <form action="{{ route('user.order.cancel', $order->order_number) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order? Stock will be restored.');">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-xs font-bold uppercase tracking-wider border border-red-400/30 text-red-400 hover:bg-red-400/10 transition">
                        Cancel Order
                    </button>
                </form>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Items -->
            <div class="lg:col-span-2">
                <div class="bg-[#1a1a1a] border border-white/10">
                    <h2 class="text-sm font-bold text-white uppercase tracking-widest p-6 pb-4">Items</h2>
                    <div class="divide-y divide-white/5">
                        @foreach($order->items as $item)
                        <div class="p-6 flex items-center gap-4">
                            <div class="w-16 h-16 flex-shrink-0 bg-black">
                                @if($item->product && $item->product->images->count() > 0)
                                    <img src="{{ storage_asset($item->product->images->first()->image_path) }}" class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('images/placeholder/product_placeholder.jpg') }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-white font-medium truncate">{{ $item->product->name ?? 'Product unavailable' }}</h3>
                                @if($item->variant)
                                <p class="text-xs text-accent">Variant: {{ $item->variant->name }}</p>
                                @endif
                                @if($item->size)<p class="text-xs text-white/40">Size: {{ $item->size }}</p>@endif
                                @if($item->color)<p class="text-xs text-white/40">Color: {{ $item->color }}</p>@endif
                                <p class="text-xs text-white/40">Qty: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-accent font-bold">৳{{ number_format($item->subtotal, 2) }}</p>
                                <p class="text-xs text-white/30">৳{{ number_format($item->price, 2) }} each</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="space-y-6">
                <!-- Totals -->
                <div class="bg-[#1a1a1a] border border-white/10 p-6">
                    <h2 class="text-sm font-bold text-white uppercase tracking-widest mb-4">Summary</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-white/50">Subtotal</span>
                            <span class="text-white">৳{{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        @if($order->discount_amount > 0)
                        <div class="flex justify-between text-green-400">
                            <span>Discount</span>
                            <span>-৳{{ number_format($order->discount_amount, 2) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-white/50">VAT</span>
                            <span class="text-white">৳{{ number_format($order->vat_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-white/50">Shipping</span>
                            <span class="text-white">৳{{ number_format($order->shipping_amount, 2) }}</span>
                        </div>
                        <div class="border-t border-white/10 pt-3 flex justify-between text-lg font-bold">
                            <span class="text-white">Total</span>
                            <span class="text-accent">৳{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="bg-[#1a1a1a] border border-white/10 p-6">
                    <h2 class="text-sm font-bold text-white uppercase tracking-widest mb-4">Payment</h2>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-white/50">Method</span>
                            <span class="text-white uppercase">{{ $order->payment_method }}</span>
                        </div>
                        @if($order->transaction_id)
                        <div class="flex justify-between">
                            <span class="text-white/50">Transaction ID</span>
                            <span class="text-white font-mono text-xs">{{ $order->transaction_id }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Shipping Address -->
                @if($order->shippingAddress)
                <div class="bg-[#1a1a1a] border border-white/10 p-6">
                    <h2 class="text-sm font-bold text-white uppercase tracking-widest mb-4">Shipping Address</h2>
                    <p class="text-white/60 text-sm leading-relaxed">{{ $order->shippingAddress->full_address }}</p>
                </div>
                @endif

                @if($order->notes)
                <div class="bg-[#1a1a1a] border border-white/10 p-6">
                    <h2 class="text-sm font-bold text-white uppercase tracking-widest mb-4">Notes</h2>
                    <p class="text-white/60 text-sm">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
