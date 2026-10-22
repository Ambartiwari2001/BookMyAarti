<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-stone-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Control Panel') - BookMyAarti Admin</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Cinzel:wght@600;700&display=swap" rel="stylesheet">

    <!-- Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-cinzel { font-family: 'Cinzel', serif; }
    </style>
</head>
<body class="h-full antialiased font-sans text-stone-800">
    <div class="min-h-full flex flex-col lg:flex-row">

        <!-- Admin Sidebar -->
        <aside class="w-full lg:w-72 bg-stone-900 text-stone-300 flex flex-col shrink-0 border-r border-stone-800">
            <!-- Sidebar Header / Brand -->
            <div class="h-20 px-6 flex items-center justify-between border-b border-stone-800 bg-stone-950/60">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-600 to-orange-500 p-0.5 shadow-md shadow-orange-500/20">
                        <div class="w-full h-full bg-stone-900 rounded-[10px] flex items-center justify-center text-amber-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C12 2 8 8 8 13C8 15.2091 9.79086 17 12 17C14.2091 17 16 15.2091 16 13C16 8 12 2 12 2Z" fill="#F59E0B" /><path d="M4 17C4 19.2091 7.58172 21 12 21C16.4183 21 20 19.2091 20 17H4Z" fill="#D97706" /></svg>
                        </div>
                    </div>
                    <div>
                        <span class="font-cinzel text-lg font-bold tracking-tight text-white">BookMy<span class="text-orange-500">Aarti</span></span>
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span class="text-[10px] tracking-wider uppercase font-semibold text-stone-400">Admin Portal</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto text-sm font-medium">
                <div class="px-3 pb-2 text-[11px] font-bold tracking-wider uppercase text-stone-500">Overview</div>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-orange-600 text-white shadow-md shadow-orange-600/30 font-semibold' : 'hover:bg-stone-800/80 hover:text-white' }}">
                    <svg class="w-5 h-5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.check-in.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.check-in.*') ? 'bg-amber-600 text-white shadow-md shadow-amber-600/30 font-semibold' : 'hover:bg-stone-800/80 text-amber-400' }}">
                    <svg class="w-5 h-5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                    Gate Pass Scanner
                </a>

                <div class="pt-5 px-3 pb-2 text-[11px] font-bold tracking-wider uppercase text-stone-500">Ceremonies & Quotas</div>

                <a href="{{ route('admin.aartis.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.aartis.*') ? 'bg-orange-600 text-white shadow-md font-semibold' : 'hover:bg-stone-800/80 hover:text-white' }}">
                    <svg class="w-5 h-5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/></svg>
                    Aarti Ceremonies
                </a>

                <a href="{{ route('admin.ghats.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.ghats.*') ? 'bg-orange-600 text-white shadow-md font-semibold' : 'hover:bg-stone-800/80 hover:text-white' }}">
                    <svg class="w-5 h-5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Holy Ghats & Locations
                </a>

                <a href="{{ route('admin.slots.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.slots.*') ? 'bg-orange-600 text-white shadow-md font-semibold' : 'hover:bg-stone-800/80 hover:text-white' }}">
                    <svg class="w-5 h-5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Slots & Capacity
                </a>

                <div class="pt-5 px-3 pb-2 text-[11px] font-bold tracking-wider uppercase text-stone-500">Devotee Operations</div>

                <a href="{{ route('admin.bookings.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.bookings.index') || request()->routeIs('admin.bookings.show') ? 'bg-orange-600 text-white shadow-md font-semibold' : 'hover:bg-stone-800/80 hover:text-white' }}">
                    <svg class="w-5 h-5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    All Bookings
                </a>

                <a href="{{ route('admin.bookings.print') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.bookings.print') ? 'bg-orange-600 text-white shadow-md font-semibold' : 'hover:bg-stone-800/80 hover:text-white' }}">
                    <svg class="w-5 h-5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Daily Sankalp Register
                </a>

                <a href="{{ route('admin.add-ons.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.add-ons.*') ? 'bg-orange-600 text-white shadow-md font-semibold' : 'hover:bg-stone-800/80 hover:text-white' }}">
                    <svg class="w-5 h-5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Offerings & Prasad
                </a>
            </nav>

            <!-- Sidebar Bottom Profile / Signout -->
            <div class="p-4 border-t border-stone-800 bg-stone-950/80">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-orange-600 text-white font-bold flex items-center justify-center text-xs">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <div class="text-xs font-bold text-white truncate">{{ auth()->user()->name ?? 'Admin' }}</div>
                            <div class="text-[10px] text-stone-400 truncate">Super Administrator</div>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-stone-400 hover:text-rose-400 p-1.5 transition-colors" title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Admin Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Top Admin Header -->
            <header class="h-20 bg-white border-b border-stone-200 px-6 sm:px-8 flex items-center justify-between shrink-0">
                <div>
                    <h1 class="text-xl font-bold text-stone-900 tracking-tight">@yield('page_title', 'Control Dashboard')</h1>
                    <p class="text-xs text-stone-500">@yield('page_subtitle', 'Ghat Aarti Trust Administration')</p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-stone-700 bg-stone-100 hover:bg-stone-200 rounded-xl transition-colors">
                        <svg class="w-4 h-4 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span>View Public Website</span>
                    </a>

                    <a href="{{ route('admin.check-in.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 rounded-xl shadow-xs transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                        <span>Gate Scanner</span>
                    </a>
                </div>
            </header>

            <!-- Alerts -->
            <div class="px-6 sm:px-8 pt-6">
                @if(session('success'))
                    <div class="flex items-center gap-3 p-4 mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm font-medium shadow-xs">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="flex items-center gap-3 p-4 mb-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 text-sm font-medium shadow-xs">
                        <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <!-- Page Body -->
            <main class="flex-1 p-6 sm:p-8 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
