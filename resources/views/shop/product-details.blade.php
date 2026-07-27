@extends('layouts.app')

@section('title', $viewModel->product->name)

@section('content')
<div class="min-h-screen">
    <!-- Breadcrumb -->
    <div class="bg-secondary border-b border-white/10">
        <div class="container mx-auto px-4 py-3">
            <nav class="text-sm flex items-center space-x-2">
                <a href="{{ route('home') }}" class="text-white/40 hover:text-accent transition">Home</a>
                <span class="text-white/20">/</span>
                <a href="{{ route('category.show', $viewModel->product->category->slug) }}" class="text-white/40 hover:text-accent transition">{{ $viewModel->product->category->name }}</a>
                <span class="text-white/20">/</span>
                <span class="text-white/70 font-medium truncate">{{ $viewModel->product->name }}</span>
            </nav>
        </div>
    </div>

    <!-- Product Details Section -->
    <div class="container mx-auto px-4 py-10 lg:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16">

            <!-- Product Images -->
            <div x-data="{ currentImage: 0 }" class="reveal-left">
                <!-- Main Image -->
                <div class="aspect-square bg-black border border-white/10 overflow-hidden mb-4 relative">
                    @if($viewModel->product->images->count() > 0)
                        @foreach($viewModel->product->images as $index => $image)
                        <div x-show="currentImage === {{ $index }}" 
                             x-transition:enter="transition ease-out duration-300" 
                             x-transition:enter-start="opacity-0" 
                             x-transition:enter-end="opacity-100"
                             class="absolute inset-0">
                            <img src="{{ storage_asset($image->image_path) }}" 
                                 alt="{{ $viewModel->product->name }}" 
                                 class="w-full h-full object-cover">
                        </div>
                        @endforeach
                    @else
                        @php
                            $detailFallback = match(strtolower($viewModel->product->category->name ?? '')) {
                                'hair care', 'hair styling' => asset('images/badlab/prod-colt45.png'),
                                'body care' => asset('images/badlab/prod-caveman.png'),
                                'facial care', 'face care', 'skin care' => asset('images/badlab/prod-babyfaced.jpg'),
                                default => asset('images/badlab/prod-colt45.png'),
                            };
                        @endphp
                        <img src="{{ $detailFallback }}" 
                             alt="{{ $viewModel->product->name }}" 
                             class="w-full h-full object-cover">
                    @endif

                    <!-- Badges -->
                    <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
                        @if($viewModel->product->discount > 0)
                        <span class="bg-danger text-white px-3 py-1 text-xs font-bold uppercase">Sale</span>
                        @endif
                        @if($viewModel->product->isNew())
                        <span class="bg-accent text-black px-3 py-1 text-xs font-bold uppercase">New</span>
                        @endif
                    </div>
                </div>
                
                <!-- Thumbnails -->
                @if($viewModel->product->images->count() > 1)
                <div class="grid grid-cols-4 gap-2">
                    @foreach($viewModel->product->images as $index => $image)
                    <button @click="currentImage = {{ $index }}" 
                            class="aspect-square overflow-hidden border-2 transition-all duration-200"
                            :class="currentImage === {{ $index }} ? 'border-accent' : 'border-white/10 hover:border-white/30'">
                        <img src="{{ storage_asset($image->image_path) }}" alt="{{ $viewModel->product->name }}" class="w-full h-full object-cover">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="flex flex-col reveal-right">
                <!-- Category -->
                <a href="{{ route('category.show', $viewModel->product->category->slug) }}" 
                   class="text-xs font-semibold text-accent uppercase tracking-widest hover:underline mb-3">
                    {{ $viewModel->product->category->name }}
                </a>

                <!-- Title -->
                <h1 class="font-heading text-3xl md:text-4xl lg:text-5xl text-white mb-4 leading-tight tracking-wide">{{ $viewModel->product->name }}</h1>

                <!-- Volume & Stock -->
                <div class="flex items-center gap-4 mb-6 text-sm">
                    @if($viewModel->product->volume)
                    <span class="text-white/50">Volume: <span class="text-white font-medium">{{ $viewModel->product->volume }}</span></span>
                    @endif
                    @if($viewModel->product->sku)
                    <span class="text-white/50">SKU: <span class="text-white/70 font-medium">{{ $viewModel->product->sku }}</span></span>
                    @endif
                    @if($viewModel->product->isInStock())
                    <span class="flex items-center gap-1.5 text-green-400">
                        <span class="w-2 h-2 bg-green-400 rounded-full inline-block"></span>
                        In Stock
                    </span>
                    @else
                    <span class="flex items-center gap-1.5 text-gray-500">
                        <span class="w-2 h-2 bg-gray-600 rounded-full inline-block"></span>
                        Out of Stock
                    </span>
                    @endif
                </div>

                <!-- Rating Summary -->
                @if($viewModel->product->reviews_count > 0)
                <div class="flex items-center gap-2 mb-4">
                    <div class="flex text-accent text-sm">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($viewModel->product->average_rating))
                                <span>&#9733;</span>
                            @else
                                <span class="text-white/20">&#9733;</span>
                            @endif
                        @endfor
                    </div>
                    <span class="text-white/50 text-sm">({{ $viewModel->product->reviews_count }} review{{ $viewModel->product->reviews_count > 1 ? 's' : '' }})</span>
                </div>
                @endif

                <!-- Variant Selector -->
                @if($viewModel->product->hasVariants())
                <div class="mb-6" x-data="{
                    selectedVariant: {{ json_encode($viewModel->product->defaultVariant ?? $viewModel->product->activeVariants->first()) }},
                    variants: {{ json_encode($viewModel->product->activeVariants) }},
                    get variantAttributes() {
                        if (!this.selectedVariant || !this.selectedVariant.attributes) return {};
                        return this.selectedVariant.attributes;
                    }
                }">
                    <template x-for="(options, attrName) in {{ json_encode($viewModel->product->getVariantOptions()) }}" :key="attrName">
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-white/50 mb-2 uppercase tracking-wider" x-text="attrName"></label>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="option in options" :key="option">
                                    <button @click="
                                        const v = variants.find(v => v.attributes && v.attributes[attrName] === option);
                                        if (v) selectedVariant = v;
                                    "
                                    :class="selectedVariant && selectedVariant.attributes && selectedVariant.attributes[attrName] === option ? 'border-accent bg-accent/10 text-accent' : 'border-white/20 text-white/60 hover:border-white/40'"
                                    class="px-4 py-2 border text-sm font-medium transition"
                                    x-text="option"></button>
                                </template>
                            </div>
                        </div>
                    </template>
                    <div x-show="selectedVariant" class="mt-3 text-sm">
                        <span class="text-white/40">Variant: </span>
                        <span class="text-white font-medium" x-text="selectedVariant.name"></span>
                        <span class="text-white/30 mx-2">|</span>
                        <span class="text-white/40">Stock: </span>
                        <span :class="selectedVariant.stock > 0 ? 'text-green-400' : 'text-red-400'" x-text="selectedVariant.stock + ' available'"></span>
                    </div>
                </div>
                @endif

                <!-- Price -->
                <div class="mb-8 pb-8 border-b border-white/10">
                    @if($viewModel->product->discount > 0)
                        <div class="flex items-baseline gap-3">
                            <span class="text-4xl font-bold text-white">৳{{ number_format($viewModel->product->getDiscountedPrice(), 2) }}</span>
                            <span class="text-xl text-white/30 line-through">৳{{ number_format($viewModel->product->price, 2) }}</span>
                        </div>
                        <p class="text-sm text-green-400 mt-2">You save ৳{{ number_format($viewModel->product->price - $viewModel->product->getDiscountedPrice(), 2) }}</p>
                    @else
                        <span class="text-4xl font-bold text-white">৳{{ number_format($viewModel->product->price, 2) }}</span>
                    @endif
                    @if($viewModel->product->hasVariants())
                        <p class="text-xs text-white/30 mt-1">Price may vary by variant</p>
                    @endif
                </div>

                <!-- Description -->
                @if($viewModel->product->description)
                <div class="mb-8">
                    <p class="text-white/60 leading-relaxed">{!! nl2br(e($viewModel->product->description)) !!}</p>
                </div>
                @endif

                <!-- Key Ingredients Highlight -->
                @if($viewModel->product->ingredients && count($viewModel->product->ingredients) > 0)
                <div class="mb-8 bg-secondary border border-accent/20 p-5">
                    <h4 class="text-accent text-xs font-bold uppercase tracking-widest mb-3">Key Ingredients</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($viewModel->product->ingredients as $ingredient)
                            <span class="bg-accent/10 text-white/80 px-3 py-1.5 text-xs font-medium border border-accent/20">{{ trim($ingredient) }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Benefits -->
                @if($viewModel->product->benefits && count($viewModel->product->benefits) > 0)
                <div class="mb-8">
                    <h4 class="text-white text-xs font-bold uppercase tracking-widest mb-3">Benefits</h4>
                    <ul class="space-y-2">
                        @foreach($viewModel->product->benefits as $benefit)
                            <li class="flex items-center gap-2 text-white/60 text-sm">
                                <svg class="w-4 h-4 text-accent flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ trim($benefit) }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Add to Cart -->
                @if($viewModel->product->isInStock())
                <div class="space-y-4 mb-8" x-data="{ qty: 1, max: {{ $viewModel->product->totalStock() }} }">
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-medium text-white/50">Qty:</span>
                        <div class="flex items-center border border-white/20">
                            <button @click="qty = Math.max(1, qty - 1)" class="w-10 h-10 flex items-center justify-center text-white/50 hover:text-accent transition font-bold">-</button>
                            <input type="number" x-model.number="qty" :max="max" min="1" class="w-14 h-10 text-center bg-transparent border-x border-white/20 text-sm font-semibold text-white focus:outline-none">
                            <button @click="qty = Math.min(max, qty + 1)" class="w-10 h-10 flex items-center justify-center text-white/50 hover:text-accent transition font-bold">+</button>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button onclick="addToCartDetail()" 
                                class="flex-1 bg-accent text-black py-3.5 hover:bg-accent/90 transition-all duration-300 font-bold text-sm uppercase tracking-widest">
                            Add to Cart
                        </button>
                        <button onclick="toggleWishlist({{ $viewModel->product->id }})" 
                                class="w-12 h-12 border border-white/20 hover:border-accent hover:text-accent transition-all duration-200 flex items-center justify-center flex-shrink-0 text-white/60"
                                title="Add to Wishlist">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                @endif

                <!-- Meta Info -->
                <div class="border-t border-white/10 pt-6 space-y-2 text-sm">
                    <div class="flex items-center gap-2">
                        <span class="text-white/40">Category:</span>
                        <a href="{{ route('category.show', $viewModel->product->category->slug) }}" class="text-accent hover:underline">{{ $viewModel->product->category->name }}</a>
                    </div>
                    @if($viewModel->product->remarks)
                    <div class="flex items-center gap-2">
                        <span class="text-white/40">Remark:</span>
                        <span class="text-white/60">{{ $viewModel->product->remarks }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Tabs -->
        <div class="mt-20" x-data="{ activeTab: 'description' }">
            <div class="border-b border-white/10">
                <nav class="flex space-x-8">
                    <button @click="activeTab = 'description'" 
                            :class="activeTab === 'description' ? 'border-accent text-accent' : 'border-transparent text-white/50 hover:text-white'"
                            class="py-4 px-1 border-b-2 font-semibold text-sm uppercase tracking-wider transition">
                        Description
                    </button>
                    @if($viewModel->product->ingredients && count($viewModel->product->ingredients) > 0)
                    <button @click="activeTab = 'ingredients'" 
                            :class="activeTab === 'ingredients' ? 'border-accent text-accent' : 'border-transparent text-white/50 hover:text-white'"
                            class="py-4 px-1 border-b-2 font-semibold text-sm uppercase tracking-wider transition">
                        Ingredients
                    </button>
                    @endif
                    @if($viewModel->product->how_to_use)
                    <button @click="activeTab = 'howtouse'" 
                            :class="activeTab === 'howtouse' ? 'border-accent text-accent' : 'border-transparent text-white/50 hover:text-white'"
                            class="py-4 px-1 border-b-2 font-semibold text-sm uppercase tracking-wider transition">
                        How to Use
                    </button>
                    @endif
                    <button @click="activeTab = 'reviews'" 
                            :class="activeTab === 'reviews' ? 'border-accent text-accent' : 'border-transparent text-white/50 hover:text-white'"
                            class="py-4 px-1 border-b-2 font-semibold text-sm uppercase tracking-wider transition">
                        Reviews
                    </button>
                </nav>
            </div>

            <div class="py-8">
                <!-- Description Tab -->
                <div x-show="activeTab === 'description'" x-transition>
                    <p class="text-white/60 leading-relaxed text-lg max-w-3xl">{!! nl2br(e($viewModel->product->description)) !!}</p>
                </div>

                <!-- Ingredients Tab -->
                @if($viewModel->product->ingredients && count($viewModel->product->ingredients) > 0)
                <div x-show="activeTab === 'ingredients'" x-transition>
                    <div class="bg-secondary border border-white/5 p-6 max-w-3xl">
                        <ul class="space-y-2">
                            @foreach($viewModel->product->ingredients as $ingredient)
                                <li class="flex items-center gap-2 text-white/60 text-sm">
                                    <span class="w-1.5 h-1.5 bg-accent rounded-full flex-shrink-0"></span>
                                    {{ trim($ingredient) }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <!-- How to Use Tab -->
                @if($viewModel->product->how_to_use)
                <div x-show="activeTab === 'howtouse'" x-transition>
                    <div class="bg-secondary border border-white/5 p-6 max-w-3xl">
                        <p class="text-white/60 leading-relaxed">{!! nl2br(e($viewModel->product->how_to_use)) !!}</p>
                    </div>
                </div>
                @endif

                <!-- Reviews Tab -->
                <div x-show="activeTab === 'reviews'" x-transition x-data="{
                    reviews: [],
                    loading: true,
                    avgRating: {{ $viewModel->product->average_rating }},
                    reviewCount: {{ $viewModel->product->reviews_count }},
                    showForm: false,
                    newReview: { rating: 5, title: '', body: '' },
                    submitting: false,
                    async loadReviews() {
                        try {
                            const res = await fetch('{{ route('product.reviews', $viewModel->product) }}');
                            const data = await res.json();
                            this.reviews = data.reviews;
                            this.avgRating = data.average_rating;
                            this.reviewCount = data.reviews_count;
                        } catch(e) { console.error(e); }
                        this.loading = false;
                    },
                    async submitReview() {
                        this.submitting = true;
                        try {
                            const res = await fetch('{{ route('product.reviews.store', $viewModel->product) }}', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                body: JSON.stringify(this.newReview)
                            });
                            const data = await res.json();
                            if (data.success) {
                                alert(data.message);
                                this.showForm = false;
                                this.newReview = { rating: 5, title: '', body: '' };
                                this.loadReviews();
                            } else {
                                alert(data.message || 'Error submitting review');
                            }
                        } catch(e) { alert('Error submitting review'); }
                        this.submitting = false;
                    },
                    init() { this.loadReviews(); }
                }">
                    <!-- Rating Summary -->
                    <div class="flex items-center gap-6 mb-8 p-6 bg-secondary border border-white/5">
                        <div class="text-center">
                            <div class="text-5xl font-bold text-white" x-text="avgRating"></div>
                            <div class="flex text-accent text-lg mt-1">
                                <template x-for="i in 5">
                                    <span :class="i <= Math.round(avgRating) ? 'text-accent' : 'text-white/20'">&#9733;</span>
                                </template>
                            </div>
                            <p class="text-white/40 text-sm mt-1" x-text="reviewCount + ' review' + (reviewCount !== 1 ? 's' : '')"></p>
                        </div>
                        <div class="flex-1">
                            @auth
                            <button @click="showForm = !showForm" class="bg-accent text-black px-6 py-2 font-bold text-sm uppercase tracking-wider hover:bg-accent/90 transition">
                                Write a Review
                            </button>
                            @else
                            <p class="text-white/40 text-sm">Please <a href="{{ route('login') }}" class="text-accent hover:underline">login</a> to write a review</p>
                            @endauth
                        </div>
                    </div>

                    <!-- Review Form -->
                    <div x-show="showForm" x-transition class="bg-secondary border border-white/10 p-6 mb-8">
                        <h4 class="text-white font-bold mb-4">Write Your Review</h4>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-white/50 mb-2">Rating</label>
                                <div class="flex gap-1 text-2xl" x-data="{ hover: 0 }">
                                    <template x-for="star in 5">
                                        <button @click="newReview.rating = star" @mouseenter="hover = star" @mouseleave="hover = 0"
                                            :class="star <= (hover || newReview.rating) ? 'text-accent' : 'text-white/20'"
                                            class="transition cursor-pointer">&#9733;</button>
                                    </template>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm text-white/50 mb-2">Title</label>
                                <input type="text" x-model="newReview.title" class="w-full px-4 py-2 bg-black border border-white/20 rounded text-white focus:outline-none focus:border-accent">
                            </div>
                            <div>
                                <label class="block text-sm text-white/50 mb-2">Your Review</label>
                                <textarea x-model="newReview.body" rows="4" class="w-full px-4 py-2 bg-black border border-white/20 rounded text-white focus:outline-none focus:border-accent"></textarea>
                            </div>
                            <button @click="submitReview()" :disabled="submitting"
                                    class="bg-accent text-black px-6 py-2 font-bold text-sm uppercase tracking-wider hover:bg-accent/90 transition disabled:opacity-50">
                                <span x-show="!submitting">Submit Review</span>
                                <span x-show="submitting">Submitting...</span>
                            </button>
                        </div>
                    </div>

                    <!-- Reviews List -->
                    <div x-show="loading" class="text-center py-8">
                        <p class="text-white/40">Loading reviews...</p>
                    </div>
                    <div x-show="!loading && reviews.length === 0" class="text-center py-12">
                        <svg class="w-16 h-16 text-white/20 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <p class="text-white/50 text-lg">No reviews yet</p>
                        <p class="text-white/30 text-sm mt-2">Be the first to review this product</p>
                    </div>
                    <div class="space-y-6">
                        <template x-for="review in reviews" :key="review.id">
                            <div class="bg-secondary border border-white/5 p-5">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-3">
                                        <div class="flex text-accent text-sm">
                                            <template x-for="i in 5">
                                                <span :class="i <= review.rating ? 'text-accent' : 'text-white/20'">&#9733;</span>
                                            </template>
                                        </div>
                                        <span class="text-white font-medium text-sm" x-text="review.user_name"></span>
                                        <span x-show="review.is_verified" class="bg-green-500/20 text-green-400 text-xs px-2 py-0.5 font-medium">Verified</span>
                                    </div>
                                    <span class="text-white/30 text-xs" x-text="review.created_at"></span>
                                </div>
                                <h5 class="text-white text-sm font-medium mb-1" x-text="review.title" x-show="review.title"></h5>
                                <p class="text-white/50 text-sm" x-text="review.body" x-show="review.body"></p>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upsell Products -->
        @if(isset($upsells) && $upsells->count() > 0)
        <section class="mt-16">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="text-accent text-xs font-semibold uppercase tracking-[0.4em] mb-2">Premium Choice</p>
                    <h2 class="font-heading text-2xl text-white tracking-wide">Better Alternatives</h2>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($upsells as $upsell)
                    @include('shop.partials.product-card', ['product' => $upsell])
                @endforeach
            </div>
        </section>
        @endif

        <!-- Cross-sell Products -->
        @if(isset($crossSells) && $crossSells->count() > 0)
        <section class="mt-16">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="text-accent text-xs font-semibold uppercase tracking-[0.4em] mb-2">Frequently Bought Together</p>
                    <h2 class="font-heading text-2xl text-white tracking-wide">Complete the Set</h2>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($crossSells as $crossSell)
                    @include('shop.partials.product-card', ['product' => $crossSell])
                @endforeach
            </div>
        </section>
        @endif

        <!-- Recently Viewed -->
        @if(isset($recentlyViewed) && $recentlyViewed->count() > 1)
        <section class="mt-16">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="text-accent text-xs font-semibold uppercase tracking-[0.4em] mb-2">Your History</p>
                    <h2 class="font-heading text-2xl text-white tracking-wide">Recently Viewed</h2>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($recentlyViewed->take(6) as $recent)
                    @if($recent->id !== $viewModel->product->id)
                        @include('shop.partials.product-card', ['product' => $recent])
                    @endif
                @endforeach
            </div>
        </section>
        @endif

        <!-- Related Products -->
        @if($viewModel->relatedProducts->count() > 0)
        <section class="mt-16">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="text-accent text-xs font-semibold uppercase tracking-[0.4em] mb-2">You May Also Like</p>
                    <h2 class="font-heading text-3xl text-white tracking-wide">Related Products</h2>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($viewModel->relatedProducts as $relatedProduct)
                    @include('shop.partials.product-card', ['product' => $relatedProduct])
                @endforeach
            </div>
        </section>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
function addToCartDetail() {
    const qtyInput = document.querySelector('[x-model\\.number="qty"]');
    const qty = qtyInput ? parseInt(qtyInput.value) || 1 : 1;

    // Check if a variant is selected (Alpine component)
    let variantId = null;
    const variantEl = document.querySelector('[x-data*="selectedVariant"]');
    if (variantEl && variantEl.__x) {
        const sv = variantEl.__x.$data.selectedVariant;
        if (sv && sv.id) variantId = sv.id;
    }

    const payload = {
        product_id: {{ $viewModel->product->id }},
        quantity: qty
    };
    if (variantId) payload.product_variant_id = variantId;

    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Product added to cart!');
            const cartCountEls = document.querySelectorAll('a[href*="cart"] span');
            cartCountEls.forEach(el => {
                if (data.cart_count !== undefined) el.textContent = data.cart_count;
            });
        } else {
            alert(data.message || 'Could not add item to cart.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Something went wrong. Please try again.');
    });
}

function toggleWishlist(productId) {
    fetch('/wishlist/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.added ? 'Added to wishlist!' : 'Removed from wishlist.');
        } else {
            alert(data.message || 'Please login to use wishlist.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Something went wrong. Please try again.');
    });
}
</script>
@endsection
