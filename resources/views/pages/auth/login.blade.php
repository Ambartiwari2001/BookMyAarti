@extends('layouts.app')

@section('title', 'Sign In - BookMyAarti')

@section('content')
<div class="py-16 sm:py-24 bg-stone-100 flex items-center justify-center min-h-[calc(100vh-200px)]">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-3xl shadow-xl border border-stone-200 p-8 sm:p-10">
            <div class="text-center mb-8">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-600 to-orange-500 p-0.5 shadow-md shadow-orange-500/20 mx-auto mb-3 flex items-center justify-center">
                    <div class="w-full h-full bg-stone-900 rounded-[14px] flex items-center justify-center text-amber-400">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C12 2 8 8 8 13C8 15.2091 9.79086 17 12 17C14.2091 17 16 15.2091 16 13C16 8 12 2 12 2Z" fill="#F59E0B" /><path d="M4 17C4 19.2091 7.58172 21 12 21C16.4183 21 20 19.2091 20 17H4Z" fill="#D97706" /></svg>
                    </div>
                </div>
                <h1 class="font-cinzel text-2xl font-bold text-stone-900">Welcome to BookMyAarti</h1>
                <p class="text-xs text-stone-500 mt-1">Sign in to manage passes or access administrative controls.</p>
            </div>

            <!-- Quick 1-Click Demo Buttons -->
            <div class="bg-amber-500/10 border border-amber-500/30 rounded-2xl p-4 mb-6">
                <span class="text-[11px] font-bold text-stone-700 block mb-2 text-center">⚡ Instant 1-Click Demo Access</span>
                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('quick-login', 'admin') }}" class="py-2 px-3 text-center text-xs font-bold text-white bg-stone-900 hover:bg-stone-800 rounded-xl transition-colors shadow-xs">
                        🛡 Admin Portal
                    </a>
                    <a href="{{ route('quick-login', 'devotee') }}" class="py-2 px-3 text-center text-xs font-bold text-white bg-orange-600 hover:bg-orange-700 rounded-xl transition-colors shadow-xs">
                        🙏 Devotee User
                    </a>
                </div>
            </div>

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Email Address</label>
                    <input type="email" name="email" required value="{{ old('email', 'admin@bookmyaarti.com') }}" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900 focus:ring-2 focus:ring-orange-500 focus:outline-hidden">
                    @error('email')
                        <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-xs font-bold text-stone-700">Password</label>
                    </div>
                    <input type="password" name="password" required value="password" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900 focus:ring-2 focus:ring-orange-500 focus:outline-hidden">
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 text-stone-600">
                        <input type="checkbox" name="remember" class="rounded-sm border-stone-300 text-orange-600 focus:ring-orange-500">
                        <span>Remember me</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white font-bold text-xs rounded-xl shadow-md transition-all">
                    Sign In
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-stone-100 text-center text-xs text-stone-500">
                Don't have an account yet? 
                <a href="{{ route('register') }}" class="font-bold text-orange-600 hover:underline">Register Here</a>
            </div>
        </div>
    </div>
</div>
@endsection
