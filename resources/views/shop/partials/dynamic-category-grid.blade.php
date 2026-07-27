<!-- Browse By Category -->
@php
    $categories = \App\Models\Category::active()->parents()->with('children')->get();
    
    $categoryImages = [
        'hair care' => asset('images/badlab/cat-hair.png'),
        'hair styling' => asset('images/badlab/cat-hair.png'),
        'body care' => asset('images/badlab/cat-body.png'),
        'facial care' => asset('images/badlab/cat-skin.png'),
        'face care' => asset('images/badlab/cat-skin.png'),
        'skin care' => asset('images/badlab/cat-skin.png'),
    ];
    
    $categoryTaglines = [
        'hair care' => 'BAD hair days never looked so good.',
        'hair styling' => 'BAD hair days never looked so good.',
        'body care' => 'Play dirty, wash clean, roam free.',
        'facial care' => 'Keep your game face on when the gloves come off.',
        'face care' => 'Keep your game face on when the gloves come off.',
        'skin care' => 'Keep your game face on when the gloves come off.',
    ];

    $totalCats = $categories->count();
    
    // Layout rules:
    // 1 category → full width single card
    // 2 categories → 2 columns equal
    // 3 categories → 2+1 stacked (1 large left, 2 stacked right)
    // 4+ categories → first group of 3 as 2+1 stacked, remaining in 2-col rows
    $firstGroup = $categories->take(3)->values();
    $remaining = $categories->slice(3)->values();
@endphp

@if($totalCats > 0)
<section class="mb-24">
    <!-- Section Header -->
    <div class="container mx-auto px-4 mb-10 reveal text-center">
        <p class="text-accent text-xs font-semibold uppercase tracking-[0.4em] mb-2">Browse By Category</p>
        <h2 class="font-heading text-3xl md:text-4xl lg:text-5xl text-white tracking-wide">OUR RANGE</h2>
        <div class="w-16 h-0.5 bg-accent mx-auto mt-4"></div>
    </div>

    <div class="container mx-auto px-4 stagger-children">

        @if($totalCats === 1)
            {{-- SINGLE CATEGORY: Full width --}}
            @php $category = $firstGroup[0]; @endphp
            @php
                $categoryNameLower = strtolower($category->name);
                $fallbackImage = $categoryImages[$categoryNameLower] ?? asset('images/badlab/cat-hair.png');
                $tagline = $categoryTaglines[$categoryNameLower] ?? '';
                $productCount = $category->children->sum(fn($c) => $c->products->count());
            @endphp
            <a href="{{ route('category.show', $category->slug) }}" 
               class="group relative block w-full h-[400px] md:h-[500px] overflow-hidden mb-2">
                @if($category->cat_image && file_exists(public_path(str_replace('storage/', 'storage/app/public/', $category->cat_image))))
                    <img src="{{ storage_asset($category->cat_image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover absolute inset-0 group-hover:scale-105 transition-transform duration-700 ease-out">
                @else
                    <img src="{{ $fallbackImage }}" alt="{{ $category->name }}" class="w-full h-full object-cover absolute inset-0 group-hover:scale-105 transition-transform duration-700 ease-out">
                @endif
                <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/50 to-black/20 group-hover:from-black/90 transition-all duration-500"></div>
                <div class="absolute inset-0 flex flex-col justify-between p-8 md:p-12">
                    <div>
                        <p class="text-accent text-xs font-semibold uppercase tracking-[0.4em] mb-3">{{ $category->name }}</p>
                        <h3 class="font-heading text-white text-4xl md:text-6xl lg:text-7xl tracking-wide leading-[0.95]">{{ $category->name }}</h3>
                    </div>
                    <div class="space-y-4">
                        @if($tagline)
                            <p class="text-white/70 text-sm md:text-base italic font-light max-w-md">{{ $tagline }}</p>
                        @endif
                        <p class="text-white/50 text-sm">{{ $productCount }} Products</p>
                        <div class="flex justify-end">
                            <span class="inline-flex items-center gap-3 text-white text-sm font-bold uppercase tracking-[0.2em] border-t border-white/30 pt-4 pr-2 group-hover:text-accent group-hover:border-accent/50 transition-colors duration-300">
                                Explore
                                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </a>

        @elseif($totalCats === 2)
            {{-- TWO CATEGORIES: 2 columns equal --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-2">
                @foreach($firstGroup as $category)
                    @php
                        $categoryNameLower = strtolower($category->name);
                        $fallbackImage = $categoryImages[$categoryNameLower] ?? asset('images/badlab/cat-hair.png');
                        $tagline = $categoryTaglines[$categoryNameLower] ?? '';
                        $productCount = $category->children->sum(fn($c) => $c->products->count());
                    @endphp
                <a href="{{ route('category.show', $category->slug) }}" 
                   class="group relative block h-[350px] md:h-[450px] overflow-hidden">
                    @if($category->cat_image && file_exists(public_path(str_replace('storage/', 'storage/app/public/', $category->cat_image))))
                        <img src="{{ storage_asset($category->cat_image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover absolute inset-0 group-hover:scale-105 transition-transform duration-700 ease-out">
                    @else
                        <img src="{{ $fallbackImage }}" alt="{{ $category->name }}" class="w-full h-full object-cover absolute inset-0 group-hover:scale-105 transition-transform duration-700 ease-out">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/50 to-black/20 group-hover:from-black/90 transition-all duration-500"></div>
                    <div class="absolute inset-0 flex flex-col justify-between p-8 md:p-10">
                        <div>
                            <p class="text-accent text-xs font-semibold uppercase tracking-[0.4em] mb-3">{{ $category->name }}</p>
                            <h3 class="font-heading text-white text-3xl md:text-5xl lg:text-6xl tracking-wide leading-[0.95]">{{ $category->name }}</h3>
                        </div>
                        <div class="space-y-4">
                            @if($tagline)
                                <p class="text-white/70 text-sm md:text-base italic font-light max-w-md">{{ $tagline }}</p>
                            @endif
                            <p class="text-white/50 text-sm">{{ $productCount }} Products</p>
                            <div class="flex justify-end">
                                <span class="inline-flex items-center gap-3 text-white text-sm font-bold uppercase tracking-[0.2em] border-t border-white/30 pt-4 pr-2 group-hover:text-accent group-hover:border-accent/50 transition-colors duration-300">
                                    Explore
                                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

        @else
            {{-- 3+ CATEGORIES: First group as 2+1 stacked, remaining in 2-col rows --}}
            @php $groupArr = $firstGroup; @endphp
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2 mb-2">
                {{-- Large Card (spans 2 cols, full height of row) --}}
                @php
                    $category = $groupArr[0];
                    $categoryNameLower = strtolower($category->name);
                    $fallbackImage = $categoryImages[$categoryNameLower] ?? asset('images/badlab/cat-hair.png');
                    $tagline = $categoryTaglines[$categoryNameLower] ?? '';
                    $productCount = $category->children->sum(fn($c) => $c->products->count());
                @endphp
                <a href="{{ route('category.show', $category->slug) }}" 
                   class="md:col-span-2 group relative block h-[350px] md:h-[700px] overflow-hidden">
                    @if($category->cat_image && file_exists(public_path(str_replace('storage/', 'storage/app/public/', $category->cat_image))))
                        <img src="{{ storage_asset($category->cat_image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover absolute inset-0 group-hover:scale-105 transition-transform duration-700 ease-out">
                    @else
                        <img src="{{ $fallbackImage }}" alt="{{ $category->name }}" class="w-full h-full object-cover absolute inset-0 group-hover:scale-105 transition-transform duration-700 ease-out">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/50 to-black/20 group-hover:from-black/90 transition-all duration-500"></div>
                    <div class="absolute inset-0 flex flex-col justify-between p-8 md:p-12">
                        <div>
                            <p class="text-accent text-xs font-semibold uppercase tracking-[0.4em] mb-3">{{ $category->name }}</p>
                            <h3 class="font-heading text-white text-4xl md:text-6xl lg:text-7xl tracking-wide leading-[0.95]">{{ $category->name }}</h3>
                        </div>
                        <div class="space-y-4">
                            @if($tagline)
                                <p class="text-white/70 text-sm md:text-base italic font-light max-w-md">{{ $tagline }}</p>
                            @endif
                            <p class="text-white/50 text-sm">{{ $productCount }} Products</p>
                            <div class="flex justify-end">
                                <span class="inline-flex items-center gap-3 text-white text-sm font-bold uppercase tracking-[0.2em] border-t border-white/30 pt-4 pr-2 group-hover:text-accent group-hover:border-accent/50 transition-colors duration-300">
                                    Explore
                                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>

                {{-- Stacked Cards (right column) --}}
                <div class="md:col-span-1 flex flex-col gap-2">
                    @for($i = 1; $i < min(3, $groupArr->count()); $i++)
                        @php
                            $category = $groupArr[$i];
                            $categoryNameLower = strtolower($category->name);
                            $fallbackImage = $categoryImages[$categoryNameLower] ?? asset('images/badlab/cat-hair.png');
                            $tagline = $categoryTaglines[$categoryNameLower] ?? '';
                            $productCount = $category->children->sum(fn($c) => $c->products->count());
                        @endphp
                    <a href="{{ route('category.show', $category->slug) }}" 
                       class="group relative block h-[350px] md:h-[340px] overflow-hidden flex-1">
                        @if($category->cat_image && file_exists(public_path(str_replace('storage/', 'storage/app/public/', $category->cat_image))))
                            <img src="{{ storage_asset($category->cat_image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover absolute inset-0 group-hover:scale-105 transition-transform duration-700 ease-out">
                        @else
                            <img src="{{ $fallbackImage }}" alt="{{ $category->name }}" class="w-full h-full object-cover absolute inset-0 group-hover:scale-105 transition-transform duration-700 ease-out">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/50 to-black/20 group-hover:from-black/90 transition-all duration-500"></div>
                        <div class="absolute inset-0 flex flex-col justify-between p-6 md:p-8">
                            <div>
                                <p class="text-accent text-[10px] font-semibold uppercase tracking-[0.4em] mb-2">{{ $category->name }}</p>
                                <h3 class="font-heading text-white text-2xl md:text-4xl tracking-wide leading-[0.95]">{{ $category->name }}</h3>
                            </div>
                            <div class="space-y-3">
                                @if($tagline)
                                    <p class="text-white/70 text-xs md:text-sm italic font-light max-w-[200px]">{{ $tagline }}</p>
                                @endif
                                <p class="text-white/50 text-xs">{{ $productCount }} Products</p>
                                <div class="flex justify-end">
                                    <span class="inline-flex items-center gap-2 text-white text-xs font-bold uppercase tracking-[0.2em] border-t border-white/30 pt-3 pr-1 group-hover:text-accent group-hover:border-accent/50 transition-colors duration-300">
                                        Explore
                                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endfor
                </div>
            </div>

            {{-- Remaining categories: 2-column rows --}}
            @if($remaining->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                @foreach($remaining as $category)
                    @php
                        $categoryNameLower = strtolower($category->name);
                        $fallbackImage = $categoryImages[$categoryNameLower] ?? asset('images/badlab/cat-hair.png');
                        $tagline = $categoryTaglines[$categoryNameLower] ?? '';
                        $productCount = $category->children->sum(fn($c) => $c->products->count());
                    @endphp
                <a href="{{ route('category.show', $category->slug) }}" 
                   class="group relative block h-[350px] overflow-hidden">
                    @if($category->cat_image && file_exists(public_path(str_replace('storage/', 'storage/app/public/', $category->cat_image))))
                        <img src="{{ storage_asset($category->cat_image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover absolute inset-0 group-hover:scale-105 transition-transform duration-700 ease-out">
                    @else
                        <img src="{{ $fallbackImage }}" alt="{{ $category->name }}" class="w-full h-full object-cover absolute inset-0 group-hover:scale-105 transition-transform duration-700 ease-out">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/50 to-black/20 group-hover:from-black/90 transition-all duration-500"></div>
                    <div class="absolute inset-0 flex flex-col justify-between p-8 md:p-10">
                        <div>
                            <p class="text-accent text-xs font-semibold uppercase tracking-[0.4em] mb-3">{{ $category->name }}</p>
                            <h3 class="font-heading text-white text-3xl md:text-5xl tracking-wide leading-[0.95]">{{ $category->name }}</h3>
                        </div>
                        <div class="space-y-4">
                            @if($tagline)
                                <p class="text-white/70 text-sm md:text-base italic font-light max-w-md">{{ $tagline }}</p>
                            @endif
                            <p class="text-white/50 text-sm">{{ $productCount }} Products</p>
                            <div class="flex justify-end">
                                <span class="inline-flex items-center gap-3 text-white text-sm font-bold uppercase tracking-[0.2em] border-t border-white/30 pt-4 pr-2 group-hover:text-accent group-hover:border-accent/50 transition-colors duration-300">
                                    Explore
                                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        @endif

    </div>
</section>
@endif
