@extends('layouts.admin')

@section('title', 'Add Banner')
@section('page-title', 'Add New Banner')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-[#1a1a1a] border border-white/10 rounded-lg p-6">
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-white/60 mb-2 uppercase tracking-wider">Title</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full px-4 py-2 bg-black border border-white/20 rounded-lg text-white focus:outline-none focus:border-accent transition">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-white/60 mb-2 uppercase tracking-wider">Link URL</label>
                <input type="url" name="link" value="{{ old('link') }}" placeholder="https://example.com"
                       class="w-full px-4 py-2 bg-black border border-white/20 rounded-lg text-white focus:outline-none focus:border-accent transition">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-white/60 mb-2 uppercase tracking-wider">Banner Image *</label>
                <input type="file" name="image" accept="image/*" required
                       class="w-full px-4 py-2 bg-black border border-white/20 rounded-lg text-white">
                <p class="text-sm text-white/30 mt-1">Accepted: JPEG, PNG, JPG, WEBP (Max 2MB)</p>
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="status" value="1" {{ old('status') ? 'checked' : '' }}
                           class="h-4 w-4 text-accent focus:ring-accent border-white/30 rounded bg-black">
                    <span class="ml-2 text-sm text-white/60">Active</span>
                </label>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-accent text-[#111111] py-2 rounded-lg hover:bg-accent/90 transition font-bold uppercase tracking-wider">
                    Create Banner
                </button>
                <a href="{{ route('admin.banners.index') }}" class="flex-1 bg-white/10 text-white py-2 rounded-lg hover:bg-white/20 transition text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
