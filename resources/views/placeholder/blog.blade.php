@extends('layouts.app')
@section('title', 'Blog')
@section('content')
<div class="bg-[#111111]">
    <div class="py-24 px-4 text-center border-b border-white/10">
        <h1 class="text-5xl md:text-6xl font-heading tracking-wider text-white mb-4">THE <span class="text-accent">LAB LOG</span></h1>
        <p class="text-white/50 uppercase tracking-widest text-sm mb-8">Grooming tips, product drops, and jungle tales</p>
        <div class="bg-[#1a1a1a] border border-white/10 rounded-lg p-12 max-w-lg mx-auto">
            <svg class="w-16 h-16 text-accent/30 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
            </svg>
            <p class="text-white/40 text-lg font-heading tracking-wide">COMING SOON</p>
            <p class="text-white/30 text-sm mt-2">We're cooking up some content in the lab.</p>
        </div>
    </div>
</div>
@endsection
