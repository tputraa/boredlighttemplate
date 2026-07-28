@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
    <div class="bg-gradient-to-br from-[#5c062c] to-[#3b021a] rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-white/70">Total Users</p>
                <p class="text-2xl font-bold mt-1 text-white/90">{{ \App\Models\User::count() }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                <svg class="w-6 h-6 text-white/90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-[#59565e]">Active Menus</p>
                <p class="text-2xl font-bold mt-1 text-[#1c1a1e]">{{ \App\Models\MstMenu::where('is_active', 1)->count() }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-[#800c3c]/10 text-[#800c3c] flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-[#59565e]">User Groups</p>
                <p class="text-2xl font-bold mt-1 text-[#1c1a1e]">{{ \App\Models\UserGroup::where('isactive', 1)->count() }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-[#800c3c]/10 text-[#800c3c] flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-[#59565e]">Your Role</p>
                <p class="text-lg font-bold mt-1 truncate text-[#1c1a1e]">{{ Auth::user()?->userGroup?->rolename ?? 'Unassigned' }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-[#800c3c]/10 text-[#800c3c] flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="mt-6 bg-white rounded-2xl shadow-sm p-6">
    <h3 class="text-lg font-semibold mb-2 text-[#1c1a1e]">Welcome, {{ Auth::user()->name }}!</h3>
    <p class="text-[#59565e]">This dashboard demonstrates a dynamic, role-based sidebar menu backed by PostgreSQL. Use the sidebar to manage menus, users, and access control.</p>
</div>
@endsection