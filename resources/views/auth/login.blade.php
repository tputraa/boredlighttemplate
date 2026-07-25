@extends('layouts.app')

@section('title', 'Login')
@section('page-title', 'Login')

@section('content')
<div class="min-h-[calc(100vh-8rem)] flex items-center justify-center">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-slate-200 p-6 lg:p-8">
        <h2 class="text-2xl font-bold text-center mb-6 text-slate-800">Welcome Back</h2>

        @if ($errors->any())
            <div class="mb-4 p-4 rounded-lg bg-[#e53e3e]/10 text-[#e53e3e] border border-[#e53e3e]/20 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring focus:ring-[#800c3c]/20 outline-none">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring focus:ring-[#800c3c]/20 outline-none">
            </div>

            <div class="flex items-center">
                <input id="remember" type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-[#800c3c] focus:ring-[#800c3c]">
                <label for="remember" class="ml-2 text-sm text-slate-600">Remember me</label>
            </div>

            <button type="submit"
                class="w-full py-2.5 px-4 rounded-xl bg-[#800c3c] hover:bg-[#60072b] text-white font-medium transition-colors">
                Sign In
            </button>
        </form>

        <p class="mt-4 text-center text-sm text-slate-500">
            Demo accounts: admin@example.com, manager@example.com, operator@example.com<br>
            Password: <strong>password</strong>
        </p>
    </div>
</div>
@endsection
