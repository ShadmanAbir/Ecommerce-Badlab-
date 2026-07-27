<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - BAD LAB</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo/ico.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo/ico.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#111111',
                        'secondary': '#1a1a1a',
                        'accent': '#c8a45c',
                    },
                    fontFamily: {
                        'heading': ['"Bebas Neue"', 'sans-serif'],
                        'sans': ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-gray-900 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-black border-r border-white/10 flex flex-col">
            <div class="p-6 border-b border-white/10">
                <h1 class="text-2xl font-heading tracking-wider text-white">BAD <span class="text-accent">LAB</span></h1>
                <p class="text-white/30 text-xs uppercase tracking-widest mt-1">Admin Panel</p>
            </div>
            <nav class="mt-4 flex-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center py-3 px-6 hover:bg-white/5 transition {{ request()->routeIs('admin.dashboard') ? 'bg-white/5 border-r-2 border-accent text-accent' : 'text-white/60' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center py-3 px-6 hover:bg-white/5 transition {{ request()->routeIs('admin.categories.*') ? 'bg-white/5 border-r-2 border-accent text-accent' : 'text-white/60' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Categories
                </a>
                <a href="{{ route('admin.banners.index') }}" class="flex items-center py-3 px-6 hover:bg-white/5 transition {{ request()->routeIs('admin.banners.*') ? 'bg-white/5 border-r-2 border-accent text-accent' : 'text-white/60' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Banners
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center py-3 px-6 hover:bg-white/5 transition {{ request()->routeIs('admin.products.*') ? 'bg-white/5 border-r-2 border-accent text-accent' : 'text-white/60' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Products
                </a>
                <hr class="border-white/10 my-4">
                <a href="{{ route('home') }}" class="flex items-center py-3 px-6 hover:bg-white/5 transition text-white/40">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    View Site
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center py-3 px-6 hover:bg-white/5 transition text-red-400/70 hover:text-red-400">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <!-- Top Bar -->
            <header class="bg-black border-b border-white/10">
                <div class="px-6 py-4 flex justify-between items-center">
                    <h2 class="text-xl font-heading tracking-wide text-white">@yield('page-title', 'Dashboard')</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-white/50 text-sm">{{ auth()->user()->name }}</span>
                        <div class="w-10 h-10 bg-accent/20 border border-accent/30 rounded-full flex items-center justify-center text-accent font-bold text-sm">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="p-6">
                @if(session('success'))
                    <div class="mb-4 bg-green-900/50 border border-green-500/30 text-green-300 px-4 py-3 rounded" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 bg-red-900/50 border border-red-500/30 text-red-300 px-4 py-3 rounded">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
