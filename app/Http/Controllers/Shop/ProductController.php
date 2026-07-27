<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\RecentlyViewed;
use App\ViewModels\ProductViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display homepage with products
     */
    public function index()
    {
        $banners = Banner::active()->get();

        return view('shop.index', compact('banners'));
    }

    /**
     * Display product details
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['category', 'images', 'stocks', 'activeVariants', 'approvedReviews.user'])
            ->firstOrFail();

        // Track view count
        $product->incrementViewsCount();

        // Track recently viewed
        $userId = auth()->id();
        $sessionId = session()->getId();
        RecentlyViewed::track($product, $userId, $sessionId);

        // Get related products (from same category)
        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('images')
            ->limit(4)
            ->get();

        // Get recently viewed products
        $recentlyViewed = RecentlyViewed::getRecent($userId, $sessionId, 6);

        // Get upsells and cross-sells
        $upsells = $product->upsells()->with('images')->limit(4)->get();
        $crossSells = $product->crossSells()->with('images')->limit(4)->get();

        $viewModel = ProductViewModel::fromProduct($product, $relatedProducts);

        return view('shop.product-details', compact('viewModel', 'recentlyViewed', 'upsells', 'crossSells'));
    }

    /**
     * Search products with filters
     */
    public function search()
    {
        $keyword = trim(request('q', ''));
        $filter = request('filter', '');
        $categoryId = request('category');
        $minPrice = request('min_price');
        $maxPrice = request('max_price');
        $sortBy = request('sort', 'latest');
        $categories = Category::active()->parents()->with('children')->get();

        $query = Product::active()->with(['images', 'category', 'approvedReviews']);

        // Apply keyword search
        if (strlen($keyword) >= 2) {
            $query->search($keyword);
        }

        // Apply category filter
        if ($categoryId) {
            $category = Category::find($categoryId);
            if ($category) {
                $childIds = $category->children->pluck('id')->push($category->id);
                $query->whereIn('category_id', $childIds);
            }
        }

        // Apply price range filter
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

        // Apply filter-based browsing
        if ($filter === 'best_seller') {
            $query->where('is_featured', true);
        } elseif ($filter === 'new_arrivals') {
            $query->where('is_new', true);
        } elseif ($filter === 'on_sale') {
            $query->where('discount', '>', 0);
        }

        // Apply sorting
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'rating':
                $query->orderByDesc(DB::raw('(SELECT AVG(rating) FROM product_reviews WHERE product_id = products.id AND is_approved = 1)'));
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12)->appends(request()->query());

        $pageTitle = $keyword ? 'Search: ' . $keyword : ($filter ? ucfirst(str_replace('_', ' ', $filter)) : 'All Products');

        return view('shop.search', compact('products', 'categories', 'keyword', 'pageTitle', 'categoryId', 'minPrice', 'maxPrice', 'sortBy'));
    }

    /**
     * Live search - returns JSON for search-as-you-type
     */
    public function liveSearch()
    {
        $keyword = trim(request('q', ''));

        if (strlen($keyword) < 2) {
            return response()->json(['products' => []]);
        }

        $products = Product::active()
            ->search($keyword)
            ->with(['images', 'category'])
            ->limit(6)
            ->get()
            ->map(function ($product) {
                $image = $product->images->first();
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'discounted_price' => $product->getDiscountedPrice(),
                    'image' => $image ? storage_asset($image->image_path) : asset('images/placeholder/product_placeholder.jpg'),
                    'category' => $product->category ? $product->category->name : '',
                    'rating' => $product->average_rating,
                ];
            });

        return response()->json(['products' => $products]);
    }

    /**
     * List products by category
     */
    public function byCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        // Get child category IDs for filtering
        $childIds = $category->children()->pluck('id')->push($category->id);

        $products = Product::active()
            ->whereIn('category_id', $childIds)
            ->with(['images', 'category', 'approvedReviews'])
            ->latest()
            ->paginate(12);

        $categories = Category::active()->parents()->get();

        return view('shop.category', compact('products', 'category', 'categories'));
    }

    /**
     * Newsletter subscription handler
     */
    public function newsletterSubscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        return back()->with('newsletter_success', 'Thanks for subscribing! Check your inbox for exclusive offers.');
    }
}
