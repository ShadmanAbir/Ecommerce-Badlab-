@extends('layouts.admin')

@section('title', 'Banners')
@section('page-title', 'Banner Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-heading tracking-wide text-white">ALL <span class="text-accent">BANNERS</span></h1>
    <a href="{{ route('admin.banners.create') }}" class="bg-accent text-[#111111] px-4 py-2 rounded-lg hover:bg-accent/90 transition font-bold uppercase tracking-wider text-sm">
        Add New Banner
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($banners as $banner)
        <div class="bg-[#1a1a1a] border border-white/10 rounded-lg overflow-hidden">
            <div class="h-48 bg-black/50">
                @if($banner->image && \Illuminate\Support\Facades\Storage::disk('uploads')->exists(str_replace('uploads/', '', $banner->image)))
                    <img src="{{ storage_asset($banner->image) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-white/10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-white mb-2">{{ $banner->title ?? 'Untitled Banner' }}</h3>
                @if($banner->link)
                    <p class="text-sm text-white/30 mb-3 truncate">Link: {{ $banner->link }}</p>
                @endif
                <div class="flex justify-between items-center">
                    <span class="px-2 py-1 text-xs rounded-full {{ $banner->status ? 'bg-green-500/20 text-green-300' : 'bg-white/10 text-white/50' }}">
                        {{ $banner->status ? 'Active' : 'Inactive' }}
                    </span>
                    <div class="space-x-2">
                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="text-accent hover:text-accent/80 text-sm">Edit</a>
                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this banner?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300 text-sm">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-12 bg-[#1a1a1a] border border-white/10 rounded-lg">
            <p class="text-white/30 text-lg">No banners found</p>
            <a href="{{ route('admin.banners.create') }}" class="inline-block mt-4 bg-accent text-[#111111] px-6 py-2 rounded-lg hover:bg-accent/90 font-bold uppercase tracking-wider text-sm">
                Create Your First Banner
            </a>
        </div>
    @endforelse
</div>
@endsection
