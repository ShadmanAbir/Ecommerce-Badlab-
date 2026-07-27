@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="bg-[#111111] min-h-screen">
    <div class="max-w-5xl mx-auto px-4 py-12">
        <h1 class="text-4xl font-heading tracking-wider text-white mb-8">MY <span class="text-accent">ORDERS</span></h1>

        @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
            <a href="{{ route('user.order.details', $order->order_number) }}" class="block bg-[#1a1a1a] border border-white/10 p-6 hover:border-accent/30 transition-all duration-300 group">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <p class="text-xs text-white/40 uppercase tracking-widest mb-1">Order</p>
                        <p class="text-white font-heading tracking-wide text-lg">{{ $order->order_number }}</p>
                        <p class="text-white/40 text-sm mt-1">{{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                    </div>
                    <div class="flex items-center gap-6">
                        <div class="text-center">
                            <p class="text-xs text-white/40 uppercase tracking-widest mb-1">Status</p>
                            <span class="inline-block px-3 py-1 text-xs font-bold uppercase tracking-wider border
                                @if($order->status === 'delivered') text-green-400 border-green-400/30
                                @elseif($order->status === 'cancelled') text-red-400 border-red-400/30
                                @elseif($order->status === 'processing') text-blue-400 border-blue-400/30
                                @elseif($order->status === 'shipped') text-purple-400 border-purple-400/30
                                @else text-yellow-400 border-yellow-400/30 @endif">
                                {{ $order->status }}
                            </span>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-white/40 uppercase tracking-widest mb-1">Payment</p>
                            <span class="inline-block px-3 py-1 text-xs font-bold uppercase tracking-wider border
                                @if($order->payment_status === 'paid') text-green-400 border-green-400/30
                                @elseif($order->payment_status === 'failed') text-red-400 border-red-400/30
                                @else text-yellow-400 border-yellow-400/30 @endif">
                                {{ $order->payment_status }}
                            </span>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-white/40 uppercase tracking-widest mb-1">Total</p>
                            <p class="text-accent font-bold text-lg">৳{{ number_format($order->total_amount, 2) }}</p>
                        </div>
                        <svg class="w-5 h-5 text-white/20 group-hover:text-accent transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </div>
                <!-- Items preview -->
                <div class="mt-4 pt-4 border-t border-white/5 flex items-center gap-3">
                    @foreach($order->items->take(3) as $item)
                    <div class="w-10 h-10 bg-black flex-shrink-0">
                        @if($item->product && $item->product->images->count() > 0)
                            <img src="{{ storage_asset($item->product->images->first()->image_path) }}" class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/placeholder/product_placeholder.jpg') }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    @endforeach
                    @if($order->items->count() > 3)
                    <span class="text-white/30 text-sm">+{{ $order->items->count() - 3 }} more</span>
                    @endif
                    <span class="text-white/30 text-sm ml-auto">{{ $order->items->sum('quantity') }} item(s)</span>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="text-center py-16">
            <svg class="w-24 h-24 mx-auto text-white/10 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <h2 class="text-2xl font-heading text-white mb-2 tracking-wide">No orders yet</h2>
            <p class="text-white/40 mb-6">Start shopping to see your orders here</p>
            <a href="{{ route('home') }}" class="inline-block bg-accent text-black px-8 py-3 hover:bg-accent/90 transition font-bold text-sm uppercase tracking-widest">
                Start Shopping
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
