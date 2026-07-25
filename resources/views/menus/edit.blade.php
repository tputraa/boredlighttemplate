@extends('layouts.app')

@section('title', 'Edit Menu')
@section('page-title', 'Edit Menu')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
    <form action="{{ route('menus.update', $menu) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-slate-700">Menu Name</label>
            <input type="text" name="menuname" value="{{ old('menuname', $menu->menuname) }}" required
                class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring focus:ring-[#800c3c]/20 outline-none">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700">Parent</label>
                <select name="menuparent" class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring focus:ring-[#800c3c]/20 outline-none">
                    <option value="0">Parent (none)</option>
                    @foreach ($parents as $parent)
                        <option value="{{ $parent->menucode }}" {{ old('menuparent', $menu->menuparent) == $parent->menucode ? 'selected' : '' }}>{{ $parent->menuname }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Type</label>
                <select name="menutype" class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring focus:ring-[#800c3c]/20 outline-none">
                    <option value="link" {{ old('menutype', $menu->menutype) == 'link' ? 'selected' : '' }}>Link</option>
                    <option value="parent" {{ old('menutype', $menu->menutype) == 'parent' ? 'selected' : '' }}>Parent</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700">Order Index</label>
                <input type="number" name="idx" value="{{ old('idx', $menu->idx) }}" min="0" required
                    class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring focus:ring-[#800c3c]/20 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Active</label>
                <select name="is_active" class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring focus:ring-[#800c3c]/20 outline-none">
                    <option value="1" {{ old('is_active', $menu->is_active) == 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ old('is_active', $menu->is_active) == 0 ? 'selected' : '' }}>No</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700">Link</label>
            <input type="text" name="menulink" value="{{ old('menulink', $menu->menulink) }}"
                class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring focus:ring-[#800c3c]/20 outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700">Icon (SVG HTML)</label>
            <textarea name="icon" rows="3"
                class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring focus:ring-[#800c3c]/20 outline-none font-mono text-xs">{{ old('icon', $menu->icon) }}</textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('menus.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 hover:bg-slate-50 text-sm font-medium text-slate-700">Cancel</a>
            <button type="submit" class="px-4 py-2 rounded-xl bg-[#800c3c] hover:bg-[#60072b] text-white text-sm font-medium transition-colors">Update</button>
        </div>
    </form>
</div>
@endsection
