@extends('layouts.app')
@section('title', 'Coupons & Offers')
@section('content')
<div class="bg-[#111111]">
    <div class="py-24 px-4 text-center border-b border-white/10">
        <h1 class="text-5xl md:text-6xl font-heading tracking-wider text-white mb-4">DEALS & <span class="text-accent">OFFERS</span></h1>
        <p class="text-white/50 uppercase tracking-widest text-sm mb-8">Exclusive deals for the lab crew</p>
        <div class="bg-[#1a1a1a] border border-white/10 rounded-lg p-12 max-w-lg mx-auto">
            <svg class="w-16 h-16 text-accent/30 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
            <p class="text-white/40 text-lg font-heading tracking-wide">COMING SOON</p>
            <p class="text-white/30 text-sm mt-2">Hot deals are being cooked in the lab.</p>
        </div>
    </div>
</div>
@endsection
