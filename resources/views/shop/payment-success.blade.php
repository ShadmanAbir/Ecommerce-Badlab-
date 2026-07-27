@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
<div class="bg-[#111111] min-h-screen flex items-center justify-center px-4">
    <div class="max-w-lg w-full text-center">
        <!-- Success Icon -->
        <div class="w-20 h-20 mx-auto mb-6 border-2 border-green-400 rounded-full flex items-center justify-center">
            <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h1 class="text-4xl font-heading tracking-wider text-white mb-3">ORDER <span class="text-accent">CONFIRMED</span></h1>
        <p class="text-white/50 mb-2">Thank you for your order!</p>
        <p class="text-white/30 text-sm mb-8">Order #{{ $order->order_number }}</p>

        <!-- Order Summary -->
        <div class="bg-[#1a1a1a] border border-white/10 p-6 text-left mb-8">
            <h2 class="text-sm font-bold text-white uppercase tracking-widest mb-4">Order Summary</h2>

            <div class="space-y-3 mb-4">
                @foreach($order->items as $item)
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 flex-shrink-0 bg-black">
                        @if($item->product && $item->product->images->count() > 0)
                            <img src="{{ storage_asset($item->product->images->first()->image_path) }}" class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/placeholder/product_placeholder.jpg') }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-white truncate">{{ $item->product->name ?? 'Product unavailable' }}</p>
                        <p class="text-xs text-white/40">Qty: {{ $item->quantity }}</p>
                    </div>
                    <p class="text-sm text-accent font-bold">৳{{ number_format($item->subtotal, 2) }}</p>
                </div>
                @endforeach
            </div>

            <div class="border-t border-white/10 pt-4 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-white/50">Subtotal</span>
                    <span class="text-white">৳{{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-white/50">VAT</span>
                    <span class="text-white">৳{{ number_format($order->vat_amount, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-white/50">Shipping</span>
                    <span class="text-white">৳{{ number_format($order->shipping_amount, 2) }}</span>
                </div>
                <div class="border-t border-white/10 pt-2 flex justify-between text-lg font-bold">
                    <span class="text-white">Total</span>
                    <span class="text-accent">৳{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-white/10 text-sm">
                <div class="flex justify-between">
                    <span class="text-white/50">Payment</span>
                    <span class="text-white uppercase">{{ $order->payment_method }}</span>
                </div>
                <div class="flex justify-between mt-1">
                    <span class="text-white/50">Status</span>
                    <span class="text-yellow-400 uppercase">{{ $order->status }}</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('user.orders') }}" class="bg-accent text-black px-8 py-3 hover:bg-accent/90 transition font-bold text-sm uppercase tracking-widest">
                View My Orders
            </a>
            <a href="{{ route('home') }}" class="border border-white/20 text-white px-8 py-3 hover:border-accent hover:text-accent transition font-bold text-sm uppercase tracking-widest">
                Continue Shopping
            </a>
        </div>
    </div>
</div>
@endsection
