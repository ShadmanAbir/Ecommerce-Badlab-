@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="bg-[#111111]">
    <div class="max-w-5xl mx-auto px-4 py-12">
        <h1 class="text-4xl font-heading tracking-wider text-white mb-8">MY <span class="text-accent">DASHBOARD</span></h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('user.orders') }}" class="bg-[#1a1a1a] border border-white/10 p-6 rounded-lg hover:border-accent/30 transition group">
                <div class="w-10 h-10 bg-accent/10 border border-accent/20 rounded flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <h3 class="text-lg font-heading tracking-wide text-white group-hover:text-accent transition">MY ORDERS</h3>
                <p class="text-white/40 mt-2 text-sm">View and track your orders</p>
            </a>
            <a href="{{ route('user.profile') }}" class="bg-[#1a1a1a] border border-white/10 p-6 rounded-lg hover:border-accent/30 transition group">
                <div class="w-10 h-10 bg-accent/10 border border-accent/20 rounded flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <h3 class="text-lg font-heading tracking-wide text-white group-hover:text-accent transition">PROFILE</h3>
                <p class="text-white/40 mt-2 text-sm">Manage your account</p>
            </a>
            <a href="{{ route('user.wishlist') }}" class="bg-[#1a1a1a] border border-white/10 p-6 rounded-lg hover:border-accent/30 transition group">
                <div class="w-10 h-10 bg-accent/10 border border-accent/20 rounded flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
                <h3 class="text-lg font-heading tracking-wide text-white group-hover:text-accent transition">WISHLIST</h3>
                <p class="text-white/40 mt-2 text-sm">Your saved items</p>
            </a>
        </div>
    </div>
</div>
@endsection
