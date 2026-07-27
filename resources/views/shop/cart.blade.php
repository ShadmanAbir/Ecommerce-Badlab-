@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="font-heading text-3xl md:text-4xl text-white mb-8 tracking-wide">Shopping Cart</h1>

    @if($viewModel->cartItems->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2 space-y-4">
            @foreach($viewModel->cartItems as $item)
            <div class="bg-secondary border border-white/5 p-4 flex items-center space-x-4">
                <!-- Product Image -->
                <div class="w-24 h-24 flex-shrink-0 bg-black">
                    @if($item->product->images->count() > 0)
                        <img src="{{ storage_asset($item->product->images->first()->image_path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                    @else
                        <img src="{{ asset('images/placeholder/product_placeholder.jpg') }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                    @endif
                </div>

                <!-- Product Info -->
                <div class="flex-1">
                    <h3 class="font-medium text-white">{{ $item->product->name }}</h3>
                    @if($item->product->volume)
                    <p class="text-xs text-white/40 mt-1">{{ $item->product->volume }}</p>
                    @endif
                    <p class="text-lg font-bold text-accent mt-2">৳{{ number_format($item->product->getDiscountedPrice(), 2) }}</p>
                </div>

                <!-- Quantity -->
                <div class="flex items-center space-x-2">
                    <button onclick="updateCart({{ $item->id }}, {{ $item->quantity - 1 }})" class="w-8 h-8 border border-white/20 hover:border-accent hover:text-accent text-white/60 transition">-</button>
                    <input type="number" value="{{ $item->quantity }}" min="1" max="{{ $item->productStock->quantity ?? 999 }}" class="w-14 text-center bg-transparent border border-white/20 text-white text-sm py-1 focus:outline-none focus:border-accent" onchange="updateCart({{ $item->id }}, this.value)">
                    <button onclick="updateCart({{ $item->id }}, {{ $item->quantity + 1 }})" class="w-8 h-8 border border-white/20 hover:border-accent hover:text-accent text-white/60 transition">+</button>
                </div>

                <!-- Subtotal -->
                <div class="text-right">
                    <p class="text-lg font-bold text-white">৳{{ number_format($item->subtotal, 2) }}</p>
                    <button onclick="removeFromCart({{ $item->id }})" class="text-danger text-xs hover:underline mt-2">Remove</button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Order Summary -->
        <div>
            <div class="bg-secondary border border-white/5 p-6 sticky top-24">
                <h2 class="text-sm font-bold text-white uppercase tracking-widest mb-4">Order Summary</h2>
                
                <div class="space-y-3 mb-4">
                    <div class="flex justify-between">
                        <span class="text-white/50">Subtotal</span>
                        <span class="text-white font-medium">৳{{ number_format($viewModel->subtotal, 2) }}</span>
                    </div>
                    @if($viewModel->discountAmount > 0)
                    <div class="flex justify-between text-green-400">
                        <span>Discount</span>
                        <span>-৳{{ number_format($viewModel->discountAmount, 2) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-white/50">VAT (5%)</span>
                        <span class="text-white font-medium">৳{{ number_format($viewModel->vatAmount, 2) }}</span>
                    </div>
                    <div class="border-t border-white/10 pt-3 flex justify-between text-lg font-bold">
                        <span class="text-white">Total</span>
                        <span class="text-accent">৳{{ number_format($viewModel->payableAmount, 2) }}</span>
                    </div>
                </div>

                <a href="{{ route('checkout.index') }}" class="block w-full bg-accent text-black text-center py-3 hover:bg-accent/90 transition font-bold text-sm uppercase tracking-widest">
                    Proceed to Checkout
                </a>

                <a href="{{ route('home') }}" class="block w-full text-center py-3 mt-3 text-accent hover:underline text-sm">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>

    @else
    <div class="text-center py-16">
        <svg class="w-24 h-24 mx-auto text-white/10 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        <h2 class="text-2xl font-heading text-white mb-2 tracking-wide">Your cart is empty</h2>
        <p class="text-white/40 mb-6">Add some products to get started!</p>
        <a href="{{ route('home') }}" class="inline-block bg-accent text-black px-8 py-3 hover:bg-accent/90 transition font-bold text-sm uppercase tracking-widest">
            Start Shopping
        </a>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function updateCart(itemId, quantity) {
    if (quantity < 1) return;
    
    fetch(`/cart/update/${itemId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) location.reload();
    });
}

function removeFromCart(itemId) {
    if (!confirm('Remove this item from cart?')) return;
    
    fetch(`/cart/remove/${itemId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) location.reload();
    });
}
</script>
@endsection
