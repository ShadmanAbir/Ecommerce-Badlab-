@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<!-- Page Loader -->
<div class="page-loader">
    <div class="loader-text">BAD LAB</div>
</div>

<div class="bg-[#111111]">
    <!-- Hero with Parallax -->
    <div class="hero-parallax relative py-32 px-4 text-center border-b border-white/10 overflow-hidden">
        <div class="hero-bg" style="background-image: url('{{ asset('images/badlab/hero-tvc.jpg') }}');"></div>
        <div class="absolute inset-0 bg-black/80 z-[1]"></div>
        <div class="absolute inset-0 noise-overlay z-[2]"></div>
        <div class="particles-container z-[1]"></div>
        <div class="relative z-10">
            <h1 class="hero-title text-5xl md:text-6xl font-heading tracking-wider text-white mb-4">ABOUT <span class="text-gradient-animated">BAD LAB</span></h1>
            <p class="hero-subtitle text-white/50 uppercase tracking-widest text-sm max-w-2xl mx-auto">Man-Gineered for the Man Who's All Walk and Little Talk</p>
        </div>
    </div>

    <!-- Brand Story -->
    <div class="max-w-5xl mx-auto px-4 py-20">
        <div class="grid md:grid-cols-2 gap-16 items-center mb-24">
            <div class="reveal-left">
                <h2 class="text-3xl font-heading tracking-wide text-white mb-6">THE <span class="text-accent">ORIGIN</span></h2>
                <p class="text-white/60 leading-relaxed mb-4">
                    Spiritually founded since the beginning of time, BAD LAB was man-gineered for one purpose: to create grooming products that actually work for men who don't settle.
                </p>
                <p class="text-white/60 leading-relaxed mb-4">
                    We're not your grandfather's soap. We're not department store filler. We're the lab where science meets swagger, where every formula is engineered for the demands of modern manhood.
                </p>
                <p class="text-white/60 leading-relaxed">
                    Welcome to the jungle. Welcome to BAD LAB.
                </p>
            </div>
            <div class="reveal-right">
                <div class="relative overflow-hidden rounded-lg group">
                    <img src="{{ asset('images/badlab/all-products.png') }}" 
                         alt="BAD Lab Products" 
                         class="w-full h-80 object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 left-4">
                        <p class="text-accent text-xs uppercase tracking-widest font-semibold">The Lab</p>
                        <p class="text-white/60 text-sm">Where it all begins</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Philosophy -->
        <div class="mb-24">
            <div class="reveal text-center mb-12">
                <h2 class="text-3xl font-heading tracking-wide text-white mb-4">OUR <span class="text-accent">PHILOSOPHY</span></h2>
                <div class="w-20 h-0.5 bg-accent mx-auto"></div>
            </div>
            <div class="grid md:grid-cols-3 gap-6 stagger-children">
                <div class="relative overflow-hidden bg-[#1a1a1a] border border-white/10 rounded-lg p-8 text-center group hover:border-accent/30 transition-all duration-500">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-accent/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="text-accent text-5xl font-heading mb-4">01</div>
                    <h3 class="text-white font-bold mb-3 uppercase tracking-wide">Active Ingredients</h3>
                    <p class="text-white/50 text-sm leading-relaxed">Every product is loaded with clinically-proven active ingredients that deliver real results.</p>
                </div>
                <div class="relative overflow-hidden bg-[#1a1a1a] border border-white/10 rounded-lg p-8 text-center group hover:border-accent/30 transition-all duration-500">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-accent/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="text-accent text-5xl font-heading mb-4">02</div>
                    <h3 class="text-white font-bold mb-3 uppercase tracking-wide">No Nonsense</h3>
                    <p class="text-white/50 text-sm leading-relaxed">No fillers, no fluff, no fairy-tale claims. Just raw, effective formulations that do what they say.</p>
                </div>
                <div class="relative overflow-hidden bg-[#1a1a1a] border border-white/10 rounded-lg p-8 text-center group hover:border-accent/30 transition-all duration-500">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-accent/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="text-accent text-5xl font-heading mb-4">03</div>
                    <h3 class="text-white font-bold mb-3 uppercase tracking-wide">Built for Men</h3>
                    <p class="text-white/50 text-sm leading-relaxed">Designed specifically for men's skin, hair, and grooming needs. Not unisex. Not diluted. Pure men's care.</p>
                </div>
            </div>
        </div>

        <!-- Full Width Parallax Image Break -->
        <div class="parallax-divider rounded-lg overflow-hidden mb-24" style="height: 250px;">
            <div class="parallax-bg" style="background-image: url('{{ asset('images/badlab/banner-ol.jpg') }}');"></div>
            <div class="parallax-overlay bg-black/60"></div>
            <div class="parallax-content h-full flex items-center justify-center text-center px-4">
                <div>
                    <p class="text-accent text-xs uppercase tracking-[0.5em] mb-3 font-semibold">The Mission</p>
                    <h2 class="font-heading text-white text-3xl md:text-4xl tracking-wide">NO COMPROMISES. NO EXCUSES.</h2>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="reveal text-center">
            <a href="{{ route('home') }}" class="inline-block bg-accent text-[#111111] px-10 py-4 font-heading tracking-wider text-lg hover:bg-accent/90 transition-all duration-300 group" data-magnetic>
                SHOP NOW
                <svg class="w-5 h-5 inline-block ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</div>
@endsection
