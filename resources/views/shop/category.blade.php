@extends('layouts.app')

@section('title', $category->name)

@section('content')
@php
    $catImages = [
        'hair care' => asset('images/badlab/cat-hair.png'),
        'hair styling' => asset('images/badlab/cat-hair.png'),
        'body care' => asset('images/badlab/cat-body.png'),
        'facial care' => asset('images/badlab/cat-skin.png'),
        'face care' => asset('images/badlab/cat-skin.png'),
        'skin care' => asset('images/badlab/cat-skin.png'),
    ];
    $catTaglines = [
        'hair care' => 'BAD hair days never looked so good.',
        'hair styling' => 'BAD hair days never looked so good.',
        'body care' => 'Play dirty, wash clean, roam free.',
        'facial care' => 'Keep your game face on when the gloves come off.',
        'face care' => 'Keep your game face on when the gloves come off.',
        'skin care' => 'Keep your game face on when the gloves come off.',
    ];
    $catNameLower = strtolower($category->name);
    $catBanner = $catImages[$catNameLower] ?? null;
    $catTagline = $catTaglines[$catNameLower] ?? '';
@endphp

<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <ol class="flex items-center space-x-2">
            <li><a href="{{ route('home') }}" class="text-white/40 hover:text-accent transition">Home</a></li>
            <li class="text-white/20">/</li>
            <li class="text-white/70 font-medium">{{ $category->name }}</li>
        </ol>
    </nav>

    <!-- Category Header -->
    @if($catBanner)
    <div class="relative h-[200px] md:h-[280px] overflow-hidden mb-8 rounded-lg">
        <div class="absolute inset-0 z-0">
            <img src="{{ $catBanner }}" alt="{{ $category->name }}" class="w-full h-full object-cover object-center">
            <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/60 to-transparent"></div>
        </div>
        <div class="relative h-full flex items-center px-8 md:px-12">
            <div class="reveal-left">
                <h1 class="font-heading text-3xl md:text-5xl lg:text-6xl text-white tracking-wide mb-2">{{ $category->name }}</h1>
                @if($catTagline)
                <p class="text-white/60 text-sm md:text-base italic">{{ $catTagline }}</p>
                @endif
                @if($category->description)
                <p class="text-white/40 text-sm mt-2">{{ $category->description }}</p>
                @endif
            </div>
        </div>
    </div>
    @else
    <div class="mb-8 pb-6 border-b border-white/10">
        <h1 class="font-heading text-3xl md:text-4xl text-white mb-2 tracking-wide">{{ $category->name }}</h1>
        @if($category->description)
        <p class="text-white/50">{{ $category->description }}</p>
        @endif
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar -->
        <aside class="lg:col-span-1">
            <div class="bg-secondary border border-white/5 p-6 sticky top-24">
                <h3 class="text-sm font-bold text-white uppercase tracking-widest mb-4">Subcategories</h3>
                @if($category->children->count() > 0)
                <ul class="space-y-2">
                    @foreach($category->children as $child)
                    <li>
                        <a href="{{ route('category.show', $child->slug) }}" class="text-white/50 hover:text-accent transition text-sm">
                            {{ $child->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-white/30 text-sm">No subcategories</p>
                @endif

                <div class="border-t border-white/10 my-6"></div>

                <h3 class="text-sm font-bold text-white uppercase tracking-widest mb-4">All Categories</h3>
                <ul class="space-y-2">
                    @foreach($categories as $cat)
                    <li>
                        <a href="{{ route('category.show', $cat->slug) }}" class="text-white/50 hover:text-accent transition text-sm {{ $cat->id === $category->id ? 'font-semibold text-accent' : '' }}">
                            {{ $cat->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <!-- Products Grid -->
        <div class="lg:col-span-3">
            @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                @foreach($products as $product)
                    @include('shop.partials.product-card', ['product' => $product])
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $products->links() }}
            </div>
            @else
            <div class="bg-secondary border border-white/5 p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-white/10 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <h3 class="text-xl font-semibold text-white mb-2">No products in this category</h3>
                <p class="text-white/40">Check back later or browse other categories</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
