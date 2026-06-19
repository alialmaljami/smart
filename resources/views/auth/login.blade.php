@extends('layouts.auth')

@section('title', 'تسجيل الدخول - ديكورات المصمم الذكي')

@section('content')
    <div class="auth-card rounded-2xl shadow-2xl border border-white/10 p-8">

        {{-- Logo / Brand --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-gold-500 to-gold-700 shadow-xl shadow-gold-500/20 mb-4 transform hover:scale-105 transition-transform duration-300">
                <i class="fas fa-pen-ruler text-2xl text-white"></i>
            </div>
            <h1 class="text-2xl font-bold text-white">ديكورات المصمم الذكي</h1>
            <p class="text-gray-500 text-sm mt-1">Smart Designer Decorations</p>
        </div>

        {{-- Error Messages --}}
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-6 h-6 rounded-full bg-red-500/20 flex items-center justify-center">
                        <i class="fas fa-exclamation-circle text-red-400 text-xs"></i>
                    </div>
                    <span class="text-red-400 text-sm font-medium">خطأ في تسجيل الدخول</span>
                </div>
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="text-red-300 text-sm pr-7">• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Login Form --}}
        <form action="{{ route('admin.login') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label for="email" class="block text-gray-400 text-sm font-medium mb-2">
                    <i class="fas fa-envelope ml-2 text-gold-500"></i>
                    البريد الإلكتروني
                </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-gold-500/50 focus:ring-1 focus:ring-gold-500/30 transition-all duration-200"
                       placeholder="admin@smartdecorations.com">
            </div>

            <div class="mb-5">
                <label for="password" class="block text-gray-400 text-sm font-medium mb-2">
                    <i class="fas fa-lock ml-2 text-gold-500"></i>
                    كلمة المرور
                </label>
                <input type="password" name="password" id="password" required
                       class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-gold-500/50 focus:ring-1 focus:ring-gold-500/30 transition-all duration-200"
                       placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input type="checkbox" name="remember" id="remember"
                           class="w-4 h-4 rounded border-white/20 bg-white/5 text-gold-500 focus:ring-gold-500/30 focus:ring-offset-0 cursor-pointer">
                    <span class="text-gray-400 text-sm group-hover:text-gray-300 transition-colors">تذكرني</span>
                </label>
            </div>

            <button type="submit"
                    class="w-full py-3 bg-gradient-to-l from-gold-600 to-gold-500 hover:from-gold-500 hover:to-gold-400 text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-gold-500/10 hover:shadow-gold-500/30 flex items-center justify-center gap-2 group">
                <i class="fas fa-sign-in-alt group-hover:translate-x-1 transition-transform"></i>
                <span>تسجيل الدخول</span>
            </button>
        </form>

        {{-- Footer --}}
        <div class="mt-8 text-center">
            <p class="text-gray-600 text-xs">© {{ date('Y') }} ديكورات المصمم الذكي. جميع الحقوق محفوظة.</p>
        </div>
    </div>
@endsection