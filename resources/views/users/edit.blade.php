@extends('layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
    <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-slate-700">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring focus:ring-[#800c3c]/20 outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring focus:ring-[#800c3c]/20 outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700">Password <span class="text-slate-400 font-normal">(leave blank to keep current)</span></label>
            <input type="password" name="password" minlength="8"
                class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring focus:ring-[#800c3c]/20 outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700">Role</label>
            <select name="user_group_id" class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring focus:ring-[#800c3c]/20 outline-none">
                <option value="">Unassigned</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->roleid }}" {{ old('user_group_id', $user->user_group_id) == $role->roleid ? 'selected' : '' }}>{{ $role->rolename }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('users.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 hover:bg-slate-50 text-sm font-medium text-slate-700">Cancel</a>
            <button type="submit" class="px-4 py-2 rounded-xl bg-[#800c3c] hover:bg-[#60072b] text-white text-sm font-medium transition-colors">Update</button>
        </div>
    </form>
</div>
@endsection
