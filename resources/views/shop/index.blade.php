@extends('layouts.app')

@section('title', 'Home - Men\'s Grooming & Personal Care')

@section('content')
<!-- Page Loader -->
<div class="page-loader">
    <div class="loader-text">BAD LAB</div>
</div>

<div class="min-h-screen">
    <!-- Hero Banner Section -->
    @php
        $banners = \App\Models\Banner::active()->get();
    @endphp
    
    @if($banners->count() > 0)
    <div class="w-full h-screen overflow-hidden">
        <div class="relative w-full h-full" x-data="{ current: 0, banners: {{ $banners->count() }} }" x-init="setInterval(() => { current = (current + 1) % banners }, 5000)">
            @foreach($banners as $index => $banner)
            <div x-show="current === {{ $index }}" 
                 x-transition:enter="transition ease-out duration-700" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0 w-full h-full">
                @php
                    $imagePath = $banner->image;
                    if (!file_exists(public_path($imagePath))) {
                        $imagePath = 'images/banner/banner_image.webp';
                    }
                @endphp
                <img src="{{ asset($imagePath) }}" alt="{{ $banner->title ?? 'BAD LAB' }}" class="w-full h-full object-cover">
            </div>
            @endforeach
            
            <!-- Banner Navigation Dots -->
            @if($banners->count() > 1)
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex space-x-2 z-10">
                @for($i = 0; $i < $banners->count(); $i++)
                <button @click="current = {{ $i }}" 
                        class="h-1.5 w-1.5 rounded-full transition-all duration-300"
                        :class="current === {{ $i }} ? 'bg-white w-6' : 'bg-white/50 hover:bg-white/80'">
                </button>
                @endfor
            </div>
            @endif
        </div>
    </div>
    @else
    <!-- Default Hero Banner -->
    <div class="w-full overflow-hidden">
        <img src="{{ asset('images/badlab/banner-caveman.png') }}" alt="BAD LAB" class="w-full h-auto object-cover">
    </div>
    @endif

    <!-- Marquee Text Strip -->
    <div class="bg-accent py-4 overflow-hidden">
        <div class="marquee-track" data-base-duration="20">
            <div class="flex items-center gap-8 px-4 whitespace-nowrap">
                <span class="text-black font-heading text-2xl md:text-3xl tracking-wider">MAN-GINEERED</span>
                <span class="text-black/30 text-xl">&#10038;</span>
                <span class="text-black font-heading text-2xl md:text-3xl tracking-wider">NO COMPROMISES</span>
                <span class="text-black/30 text-xl">&#10038;</span>
                <span class="text-black font-heading text-2xl md:text-3xl tracking-wider">REPLENISHES MINERALS</span>
                <span class="text-black/30 text-xl">&#10038;</span>
                <span class="text-black font-heading text-2xl md:text-3xl tracking-wider">BUILT FOR MEN</span>
                <span class="text-black/30 text-xl">&#10038;</span>
                <span class="text-black font-heading text-2xl md:text-3xl tracking-wider">LAB TESTED</span>
                <span class="text-black/30 text-xl">&#10038;</span>
                <span class="text-black font-heading text-2xl md:text-3xl tracking-wider">PROTECTS &amp; REJUVENATES</span>
                <span class="text-black/30 text-xl">&#10038;</span>
            </div>
            <div class="flex items-center gap-8 px-4 whitespace-nowrap">
                <span class="text-black font-heading text-2xl md:text-3xl tracking-wider">MAN-GINEERED</span>
                <span class="text-black/30 text-xl">&#10038;</span>
                <span class="text-black font-heading text-2xl md:text-3xl tracking-wider">NO COMPROMISES</span>
                <span class="text-black/30 text-xl">&#10038;</span>
                <span class="text-black font-heading text-2xl md:text-3xl tracking-wider">REPLENISHES MINERALS</span>
                <span class="text-black/30 text-xl">&#10038;</span>
                <span class="text-black font-heading text-2xl md:text-3xl tracking-wider">BUILT FOR MEN</span>
                <span class="text-black/30 text-xl">&#10038;</span>
                <span class="text-black font-heading text-2xl md:text-3xl tracking-wider">LAB TESTED</span>
                <span class="text-black/30 text-xl">&#10038;</span>
                <span class="text-black font-heading text-2xl md:text-3xl tracking-wider">PROTECTS &amp; REJUVENATES</span>
                <span class="text-black/30 text-xl">&#10038;</span>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="reveal mt-16 md:mt-24">
        @include('shop.partials.dynamic-category-grid')
    </div>

    <!-- Manifesto / Brand Story -->
    @include('shop.partials._manifesto')

    <!-- Most Popular - THE ESSENTIALS (after categories) -->
    @include('shop.partials._most-popular')

    <!-- Try BAD Banner -->
    @include('shop.partials._try-bad-banner')

    <!-- Category-wise Product Sections with Philosophy & Ritual -->
    @php
        $parentCategories = \App\Models\Category::active()->parents()->get();
        $hairCare = $parentCategories->firstWhere('name', 'Hair Care');
        $bodyCare = $parentCategories->firstWhere('name', 'Body Care');
        $facialCare = $parentCategories->firstWhere('name', 'Facial Care');
    @endphp

    {{-- Hair Care Products --}}
    @if($hairCare)
        @include('shop.partials._category-products', ['parentCategory' => $hairCare])
    @endif

    {{-- The Lab Philosophy - Why BAD is GOOD --}}
    @include('shop.partials._why-bad-is-good')

    {{-- Body Care Products --}}
    @if($bodyCare)
        @include('shop.partials._category-products', ['parentCategory' => $bodyCare])
    @endif

    {{-- The Ritual - Your Daily Armour --}}
    @include('shop.partials._your-daily-armour')

    {{-- Facial Care Products --}}
    @if($facialCare)
        @include('shop.partials._category-products', ['parentCategory' => $facialCare])
    @endif

    <!-- Newsletter Subscription -->
    @include('shop.partials._newsletter')

    <!-- Section Divider -->
    <div class="w-full h-px bg-accent/30"></div>

    <!-- Service Features -->
    <section class="mb-8 container mx-auto px-4 py-16">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 stagger-children">
            <div class="bg-secondary border border-white/5 p-6 text-center hover:border-accent/30 transition-all duration-300 group">
                <div class="w-12 h-12 mx-auto mb-3 bg-accent/10 rounded flex items-center justify-center group-hover:bg-accent/20 group-hover:scale-110 transition-all duration-300">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                </div>
                <h3 class="text-white text-xs font-bold uppercase tracking-wider mb-1">Free Shipping</h3>
                <p class="text-white/40 text-xs">On orders over 999</p>
            </div>

            <div class="bg-secondary border border-white/5 p-6 text-center hover:border-accent/30 transition-all duration-300 group">
                <div class="w-12 h-12 mx-auto mb-3 bg-accent/10 rounded flex items-center justify-center group-hover:bg-accent/20 group-hover:scale-110 transition-all duration-300">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-white text-xs font-bold uppercase tracking-wider mb-1">Secure Payment</h3>
                <p class="text-white/40 text-xs">100% secure checkout</p>
            </div>

            <div class="bg-secondary border border-white/5 p-6 text-center hover:border-accent/30 transition-all duration-300 group">
                <div class="w-12 h-12 mx-auto mb-3 bg-accent/10 rounded flex items-center justify-center group-hover:bg-accent/20 group-hover:scale-110 transition-all duration-300">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                <h3 class="text-white text-xs font-bold uppercase tracking-wider mb-1">Easy Returns</h3>
                <p class="text-white/40 text-xs">30-day hassle-free</p>
            </div>

            <div class="bg-secondary border border-white/5 p-6 text-center hover:border-accent/30 transition-all duration-300 group">
                <div class="w-12 h-12 mx-auto mb-3 bg-accent/10 rounded flex items-center justify-center group-hover:bg-accent/20 group-hover:scale-110 transition-all duration-300">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <h3 class="text-white text-xs font-bold uppercase tracking-wider mb-1">Quality Guaranteed</h3>
                <p class="text-white/40 text-xs">Lab-tested products</p>
            </div>
        </div>
    </section>
</div>
@endsection
