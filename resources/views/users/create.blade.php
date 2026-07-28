@extends('layouts.app')

@section('title', 'New User')
@section('page-title', 'New User')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm p-6">
    <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-[#59565e]">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring-1 focus:ring-[#800c3c] outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-[#59565e]">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring-1 focus:ring-[#800c3c] outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-[#59565e]">Password</label>
            <input type="password" name="password" required minlength="8"
                class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring-1 focus:ring-[#800c3c] outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-[#59565e]">Role</label>
            <select name="user_group_id" class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring-1 focus:ring-[#800c3c] outline-none">
                <option value="">Unassigned</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->roleid }}" {{ old('user_group_id') == $role->roleid ? 'selected' : '' }}>{{ $role->rolename }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('users.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 hover:bg-[#dcd9e0] text-sm font-medium text-[#59565e]">Cancel</a>
            <button type="submit" class="px-4 py-2 rounded-xl bg-[#800c3c] hover:bg-[#60072b] text-white text-sm font-medium transition-colors">Save</button>
        </div>
    </form>
</div>
@endsection