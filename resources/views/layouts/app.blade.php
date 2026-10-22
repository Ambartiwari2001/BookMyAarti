<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-stone-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Book Sacred Ganga Aarti Passes Online') - BookMyAarti</title>
    <meta name="description" content="@yield('meta_description', 'Official portal to book Ganga Aarti passes, VIP platform seating, and special Sankalp rituals at Dashashwamedh Ghat Varanasi, Har Ki Pauri Haridwar, and Triveni Ghat Rishikesh.')">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-cinzel { font-family: 'Cinzel', serif; }
    </style>
</head>
<body class="flex flex-col min-h-screen text-stone-800 antialiased selection:bg-orange-500 selection:text-white">

    <!-- Top Sacred Notification Bar -->
    <div class="bg-stone-900 text-stone-300 text-xs py-2 px-4 border-b border-stone-800">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 text-amber-400 font-medium">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    ॥ ॐ नमः शिवाय ॥ हर हर गंगे ॥
                </span>
                <span class="hidden md:inline text-stone-500">|</span>
                <span class="hidden md:inline text-stone-400">Evening Ganga Aarti Daily Timings: 06:15 PM – 07:30 PM</span>
            </div>
            <div class="flex items-center gap-4 text-stone-400">
                <a href="{{ route('my-bookings') }}" class="hover:text-amber-400 transition-colors">Find My Pass</a>
                <span class="text-stone-700">|</span>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-amber-400 font-semibold hover:underline flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                            Admin Control
                        </a>
                    @endif
                @else
                    <a href="{{ route('quick-login', 'admin') }}" class="text-amber-400/90 hover:text-amber-300 transition-colors">Admin Demo</a>
                @endauth
                <span class="text-stone-700">|</span>
                <span>Helpline: +91 542 2277123</span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-stone-200/80 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-600 via-orange-500 to-amber-400 p-0.5 shadow-md shadow-orange-500/20 group-hover:scale-105 transition-transform">
                        <div class="w-full h-full bg-stone-900 rounded-[14px] flex items-center justify-center text-amber-400">
                            <!-- Diya / Flame Icon -->
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C12 2 8 8 8 13C8 15.2091 9.79086 17 12 17C14.2091 17 16 15.2091 16 13C16 8 12 2 12 2Z" fill="#F59E0B" />
                                <path d="M4 17C4 19.2091 7.58172 21 12 21C16.4183 21 20 19.2091 20 17H4Z" fill="#D97706" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <span class="font-cinzel text-2xl font-bold tracking-tight text-stone-900 group-hover:text-orange-600 transition-colors">
                            BookMy<span class="text-orange-600">Aarti</span>
                        </span>
                        <p class="text-[10px] uppercase tracking-widest font-semibold text-amber-700">Ganga Seva & Darshan Passes</p>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-stone-700">
                    <a href="{{ route('home') }}" class="transition-colors hover:text-orange-600 {{ request()->routeIs('home') ? 'text-orange-600' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('aartis.index') }}" class="transition-colors hover:text-orange-600 {{ request()->routeIs('aartis.*') ? 'text-orange-600' : '' }}">
                        Book Aarti
                    </a>
                    <a href="{{ route('ghats.index') }}" class="transition-colors hover:text-orange-600 {{ request()->routeIs('ghats.*') ? 'text-orange-600' : '' }}">
                        Sacred Ghats
                    </a>
                    <a href="{{ route('my-bookings') }}" class="transition-colors hover:text-orange-600 {{ request()->routeIs('my-bookings') ? 'text-orange-600' : '' }}">
                        My Passes
                    </a>
                </nav>

                <!-- Auth / Quick Action Buttons -->
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        <div class="flex items-center gap-3">
                            <div class="text-right">
                                <div class="text-xs font-bold text-stone-900">{{ auth()->user()->name }}</div>
                                <div class="text-[11px] text-stone-500 capitalize">{{ auth()->user()->role }}</div>
                            </div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="p-2 text-stone-400 hover:text-stone-700 rounded-lg hover:bg-stone-100 transition-colors" title="Logout">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-xs font-semibold text-stone-700 hover:text-stone-900 border border-stone-300 rounded-xl hover:bg-stone-50 transition-all">
                            Sign In
                        </a>
                        <a href="{{ route('aartis.index') }}" class="px-5 py-2.5 text-xs font-bold text-white bg-gradient-to-r from-orange-600 via-amber-600 to-orange-500 rounded-xl shadow-md shadow-orange-500/25 hover:shadow-lg hover:from-orange-700 hover:to-orange-600 transition-all transform active:scale-95">
                            Book Aarti Slot
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <a href="{{ route('aartis.index') }}" class="mr-2 px-3 py-1.5 text-xs font-bold text-white bg-orange-600 rounded-lg">
                        Book
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Notifications -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="flex items-center gap-3 p-4 mb-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 shadow-xs">
                <svg class="w-6 h-6 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="text-sm font-medium">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-center gap-3 p-4 mb-3 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 shadow-xs">
                <svg class="w-6 h-6 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="text-sm font-medium">{{ session('error') }}</div>
            </div>
        @endif

        @if(session('warning'))
            <div class="flex items-center gap-3 p-4 mb-3 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 shadow-xs">
                <svg class="w-6 h-6 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <div class="text-sm font-medium">{{ session('warning') }}</div>
            </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-stone-950 text-stone-400 mt-20 border-t border-stone-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <!-- Column 1: About -->
                <div class="space-y-4 md:col-span-1">
                    <div class="flex items-center gap-2">
                        <span class="font-cinzel text-xl font-bold tracking-tight text-white">
                            BookMy<span class="text-orange-500">Aarti</span>
                        </span>
                    </div>
                    <p class="text-xs leading-relaxed text-stone-400">
                        A dedicated digital initiative facilitating verified Ganga Aarti passes, VIP dais darshan, and sacred Sankalp puja offerings at the historic riverbanks of Varanasi, Haridwar, and Rishikesh.
                    </p>
                    <div class="text-xs text-amber-500 font-medium">
                        ॥ हर हर गंगे ॥ नमामि गंगे ॥
                    </div>
                </div>

                <!-- Column 2: Holy Destinations -->
                <div>
                    <h3 class="font-cinzel text-sm font-bold uppercase tracking-wider text-white mb-4">Holy Ghats</h3>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="{{ route('ghats.show', 'dashashwamedh-ghat-varanasi') }}" class="hover:text-amber-400 transition-colors">Dashashwamedh Ghat (Varanasi)</a></li>
                        <li><a href="{{ route('ghats.show', 'har-ki-pauri-haridwar') }}" class="hover:text-amber-400 transition-colors">Har Ki Pauri (Haridwar)</a></li>
                        <li><a href="{{ route('ghats.show', 'triveni-ghat-rishikesh') }}" class="hover:text-amber-400 transition-colors">Triveni Ghat (Rishikesh)</a></li>
                        <li><a href="{{ route('ghats.show', 'assi-ghat-varanasi') }}" class="hover:text-amber-400 transition-colors">Assi Ghat - Subah-e-Banaras</a></li>
                    </ul>
                </div>

                <!-- Column 3: Quick Services -->
                <div>
                    <h3 class="font-cinzel text-sm font-bold uppercase tracking-wider text-white mb-4">Devotee Services</h3>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="{{ route('aartis.index') }}" class="hover:text-amber-400 transition-colors">Daily Aarti Pass Reservation</a></li>
                        <li><a href="{{ route('my-bookings') }}" class="hover:text-amber-400 transition-colors">Download E-Pass / QR Ticket</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-amber-400 transition-colors">Devotee Login</a></li>
                        <li><a href="{{ route('admin.dashboard') }}" class="hover:text-amber-400 transition-colors">Ghat Trust Admin Portal</a></li>
                    </ul>
                </div>

                <!-- Column 4: Ghat Advisory & Helpline -->
                <div>
                    <h3 class="font-cinzel text-sm font-bold uppercase tracking-wider text-white mb-4">Ghat Advisory</h3>
                    <div class="bg-stone-900 border border-stone-800 rounded-xl p-4 text-xs space-y-2 text-stone-300">
                        <div class="flex items-start gap-2">
                            <span class="text-amber-400 font-bold">✓</span>
                            <span>Report 45 minutes before twilight Aarti for tier entry.</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="text-amber-400 font-bold">✓</span>
                            <span>Keep mobile E-Pass QR code ready at Gate 3.</span>
                        </div>
                        <div class="pt-2 text-[11px] text-stone-400 border-t border-stone-800">
                            Emergency Seva Helpline: <span class="text-amber-400 font-semibold">+91 542 2277123</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-stone-800 mt-12 pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-stone-500 gap-4">
                <p>&copy; {{ date('Y') }} BookMyAarti. Managed by Sacred River Heritage Trust. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a href="{{ route('quick-login', 'admin') }}" class="hover:text-stone-300">Admin Login</a>
                    <a href="{{ route('quick-login', 'devotee') }}" class="hover:text-stone-300">Devotee Demo</a>
                    <a href="{{ route('my-bookings') }}" class="hover:text-stone-300">Track Pass</a>
                </div>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
