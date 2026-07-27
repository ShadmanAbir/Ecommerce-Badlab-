<!-- Product Card Component - BadLab Dark Theme -->
<div class="product-card-enhanced bg-secondary border border-white/5 overflow-hidden group">
    <a href="{{ route('product.show', $product->slug) }}" class="block">
        <!-- Product Image -->
        <div class="product-image-wrap relative aspect-square overflow-hidden bg-black">
            @if($product->images->count() > 0)
                <img src="{{ storage_asset($product->images->first()->image_path) }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            @else
                @php
                    $catFallback = match(strtolower($product->category->name ?? '')) {
                        'hair care', 'hair styling' => asset('images/badlab/prod-colt45.png'),
                        'body care' => asset('images/badlab/prod-caveman.png'),
                        'facial care', 'face care', 'skin care' => asset('images/badlab/prod-babyfaced.jpg'),
                        default => asset('images/badlab/prod-colt45.png'),
                    };
                @endphp
                <img src="{{ $catFallback }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            @endif
            
            <!-- Badges -->
            <div class="absolute top-3 left-3 flex flex-col gap-2">
                @if($product->discount > 0)
                <span class="bg-danger text-white px-2 py-1 text-xs font-bold uppercase">Sale</span>
                @endif
                @if($product->isNew())
                <span class="bg-accent text-black px-2 py-1 text-xs font-bold uppercase">New</span>
                @endif
                @if($product->is_trending)
                <span class="bg-white text-black px-2 py-1 text-xs font-bold uppercase">Bestseller</span>
                @endif
            </div>
            
            <!-- Volume indicator -->
            @if($product->volume)
            <div class="absolute bottom-3 right-3">
                <span class="bg-black/70 text-white/80 px-2 py-1 text-xs font-medium">{{ $product->volume }}</span>
            </div>
            @endif
        </div>
        
        <!-- Product Info -->
        <div class="p-4">
            <!-- Category -->
            <p class="text-accent/60 text-[10px] font-semibold uppercase tracking-widest mb-1">{{ $product->category->name ?? '' }}</p>
            
            <h3 class="text-sm font-medium text-white/90 line-clamp-2 mb-2 group-hover:text-accent transition">
                {{ $product->name }}
            </h3>
            
            <!-- Price -->
            <div class="flex items-center space-x-2 mb-3">
                @if($product->discount > 0)
                    <span class="text-lg font-bold text-white">৳{{ number_format($product->getDiscountedPrice(), 2) }}</span>
                    <span class="text-sm text-white/40 line-through">৳{{ number_format($product->price, 2) }}</span>
                @else
                    <span class="text-lg font-bold text-white">৳{{ number_format($product->price, 2) }}</span>
                @endif
            </div>
            
            <!-- Stock Status -->
            @if(!$product->isInStock())
            <div class="text-xs font-medium px-2 py-1 bg-gray-600/30 text-gray-500 uppercase tracking-wider">Out of Stock</div>
            @endif
        </div>
    </a>
    
    <!-- Add to Cart -->
    @if($product->isInStock())
    <div class="px-4 pb-4">
        <button onclick="addToCart({{ $product->id }})" 
                class="w-full bg-accent text-black py-2.5 hover:bg-accent/90 transition text-xs font-bold uppercase tracking-widest">
            Add to Cart
        </button>
    </div>
    @endif
</div>
