@extends('layouts.admin')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-[#1a1a1a] border border-white/10 rounded-lg p-6">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-white/60 mb-2 uppercase tracking-wider">Category Name *</label>
                <input type="text" name="name" required value="{{ old('name', $category->name) }}"
                       class="w-full px-4 py-2 bg-black border border-white/20 rounded-lg text-white focus:outline-none focus:border-accent transition">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-white/60 mb-2 uppercase tracking-wider">Description</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2 bg-black border border-white/20 rounded-lg text-white focus:outline-none focus:border-accent transition">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-white/60 mb-2 uppercase tracking-wider">Category Image</label>
                @if($category->cat_image)
                    <div class="mb-2">
                        <img src="{{ storage_asset($category->cat_image) }}" alt="{{ $category->name }}" class="w-32 h-32 object-cover rounded">
                        <p class="text-sm text-white/30">Current image</p>
                    </div>
                @endif
                <input type="file" name="cat_image" accept="image/*"
                       class="w-full px-4 py-2 bg-black border border-white/20 rounded-lg text-white">
                <p class="text-sm text-white/30 mt-1">Upload new image to replace current (Max 2MB)</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-white/60 mb-2 uppercase tracking-wider">Parent Category</label>
                <select name="parent_id" class="w-full px-4 py-2 bg-black border border-white/20 rounded-lg text-white focus:outline-none focus:border-accent transition">
                    <option value="">None (This is a parent category)</option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-white/60 mb-2 uppercase tracking-wider">Status *</label>
                <select name="status" required class="w-full px-4 py-2 bg-black border border-white/20 rounded-lg text-white focus:outline-none focus:border-accent transition">
                    <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-accent text-[#111111] py-2 rounded-lg hover:bg-accent/90 transition font-bold uppercase tracking-wider">
                    Update Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="flex-1 bg-white/10 text-white py-2 rounded-lg hover:bg-white/20 transition text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
