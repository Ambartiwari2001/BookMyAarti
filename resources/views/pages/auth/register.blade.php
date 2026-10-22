@extends('layouts.app')

@section('title', 'Register Devotee Account - BookMyAarti')

@section('content')
<div class="py-16 sm:py-24 bg-stone-100 flex items-center justify-center min-h-[calc(100vh-200px)]">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-3xl shadow-xl border border-stone-200 p-8 sm:p-10">
            <div class="text-center mb-8">
                <h1 class="font-cinzel text-2xl font-bold text-stone-900">Create Devotee Account</h1>
                <p class="text-xs text-stone-500 mt-1">Keep track of your Aarti passes and family Sankalp history.</p>
            </div>

            <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Full Name</label>
                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="Devotee name" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900 focus:ring-2 focus:ring-orange-500 focus:outline-hidden">
                    @error('name')
                        <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Email Address</label>
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="devotee@example.com" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900 focus:ring-2 focus:ring-orange-500 focus:outline-hidden">
                    @error('email')
                        <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Mobile Phone (WhatsApp)</label>
                    <input type="text" name="phone" required value="{{ old('phone') }}" placeholder="+91 98765 43210" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900 focus:ring-2 focus:ring-orange-500 focus:outline-hidden">
                    @error('phone')
                        <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Password</label>
                    <input type="password" name="password" required placeholder="Minimum 6 characters" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900 focus:ring-2 focus:ring-orange-500 focus:outline-hidden">
                    @error('password')
                        <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" required placeholder="Re-enter password" 
                           class="w-full bg-stone-50 border border-stone-300 rounded-xl px-3.5 py-2.5 text-xs text-stone-900 focus:ring-2 focus:ring-orange-500 focus:outline-hidden">
                </div>

                <button type="submit" class="w-full py-3 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white font-bold text-xs rounded-xl shadow-md transition-all">
                    Register Account
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-stone-100 text-center text-xs text-stone-500">
                Already registered? 
                <a href="{{ route('login') }}" class="font-bold text-orange-600 hover:underline">Sign In</a>
            </div>
        </div>
    </div>
</div>
@endsection
