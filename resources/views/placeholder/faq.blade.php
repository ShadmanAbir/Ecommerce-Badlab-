@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
<div class="bg-[#111111]">
    <!-- Hero -->
    <div class="relative py-16 px-4 text-center border-b border-white/10">
        <h1 class="text-5xl md:text-6xl font-heading tracking-wider text-white mb-4">FREQ <span class="text-accent">QUESTIONS</span></h1>
        <p class="text-white/50 uppercase tracking-widest text-sm">Everything you need to know</p>
    </div>

    <div class="max-w-3xl mx-auto px-4 py-16" x-data="{ open: null }">
        <div class="space-y-3">
            @php
            $faqs = [
                ['q' => 'What makes BAD LAB different?', 'a' => 'BAD LAB products are man-gineered specifically for men. We use clinically-proven active ingredients, no fillers, and every formula is designed for men\'s unique skin and hair needs.'],
                ['q' => 'Are your products suitable for sensitive skin?', 'a' => 'Yes! Our formulations are designed to be effective yet gentle. However, we always recommend patch testing any new product. If you have specific concerns, check the ingredients list or contact us.'],
                ['q' => 'How long does delivery take?', 'a' => 'Within Dhaka: 1-2 business days. Outside Dhaka: 3-5 business days. We offer free shipping on orders over ৳999.'],
                ['q' => 'What is your return policy?', 'a' => 'We offer a 30-day return policy on all unopened products. If a product doesn\'t work for you, reach out to our support team and we\'ll make it right.'],
                ['q' => 'Do you test on animals?', 'a' => 'No. BAD LAB is proudly cruelty-free. We never test on animals.'],
                ['q' => 'How can I track my order?', 'a' => 'Once your order is shipped, you\'ll receive a tracking number via email/SMS. You can also check your order status in your account dashboard.'],
                ['q' => 'What payment methods do you accept?', 'a' => 'We accept Cash on Delivery (COD), bKash, Nagad, and bank card payments (Visa/Mastercard).'],
            ];
            @endphp

            @foreach($faqs as $i => $faq)
                <div class="border border-white/10 rounded-lg overflow-hidden">
                    <button @click="open === {{ $i }} ? open = null : open = {{ $i }}"
                            class="w-full flex justify-between items-center px-6 py-4 text-left hover:bg-white/5 transition">
                        <span class="text-white font-medium">{{ $faq['q'] }}</span>
                        <svg class="w-5 h-5 text-accent flex-shrink-0 ml-4 transition-transform" :class="{ 'rotate-180': open === {{ $i }} }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open === {{ $i }}" x-collapse class="px-6 pb-4">
                        <p class="text-white/50">{{ $faq['a'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <p class="text-white/40 mb-4">Still have questions?</p>
            <a href="{{ route('contact') }}" class="inline-block border border-accent text-accent px-8 py-3 font-heading tracking-wider hover:bg-accent hover:text-[#111111] transition">
                CONTACT US
            </a>
        </div>
    </div>
</div>
@endsection
