@extends('layouts.admin')

@section('title', 'Categories')
@section('page-title', 'Category Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-heading tracking-wide text-white">ALL <span class="text-accent">CATEGORIES</span></h1>
    <a href="{{ route('admin.categories.create') }}" class="bg-accent text-[#111111] px-4 py-2 rounded-lg hover:bg-accent/90 transition font-bold uppercase tracking-wider text-sm">
        Add New Category
    </a>
</div>

<div class="bg-[#1a1a1a] border border-white/10 rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-white/10">
        <thead class="bg-black/50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-white/40 uppercase tracking-wider">Image</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white/40 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white/40 uppercase tracking-wider">Parent</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-white/40 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-white/40 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse($categories as $category)
                <tr class="hover:bg-white/5 transition">
                    <td class="px-6 py-4">
                        @if($category->cat_image)
                            <img src="{{ storage_asset($category->cat_image) }}" alt="{{ $category->name }}" class="w-12 h-12 object-cover rounded">
                        @else
                            <div class="w-12 h-12 bg-white/5 border border-white/10 rounded flex items-center justify-center">
                                <svg class="w-6 h-6 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-white">{{ $category->name }}</div>
                        <div class="text-sm text-white/30">{{ $category->slug }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-white/50">
                        {{ $category->parent->name ?? 'None (Parent)' }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full {{ $category->status == 'active' ? 'bg-green-500/20 text-green-300' : 'bg-white/10 text-white/50' }}">
                            {{ ucfirst($category->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right text-sm font-medium space-x-3">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-accent hover:text-accent/80">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-white/30">No categories found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
