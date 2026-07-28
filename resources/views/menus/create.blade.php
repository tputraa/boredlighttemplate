@extends('layouts.app')

@section('title', 'New Menu')
@section('page-title', 'New Menu')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm p-6">
    <form action="{{ route('menus.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-[#59565e]">Menu Name</label>
            <input type="text" name="menuname" value="{{ old('menuname') }}" required
                class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring-1 focus:ring-[#800c3c] outline-none">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-[#59565e]">Parent</label>
                <select name="menuparent" class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring-1 focus:ring-[#800c3c] outline-none">
                    <option value="0">Parent (none)</option>
                    @foreach ($parents as $parent)
                        <option value="{{ $parent->menucode }}" {{ old('menuparent') == $parent->menucode ? 'selected' : '' }}>{{ $parent->menuname }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-[#59565e]">Type</label>
                <select name="menutype" class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring-1 focus:ring-[#800c3c] outline-none">
                    <option value="link" {{ old('menutype') == 'link' ? 'selected' : '' }}>Link</option>
                    <option value="parent" {{ old('menutype') == 'parent' ? 'selected' : '' }}>Parent</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-[#59565e]">Order Index</label>
                <input type="number" name="idx" value="{{ old('idx', 0) }}" min="0" required
                    class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring-1 focus:ring-[#800c3c] outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-[#59565e]">Active</label>
                <select name="is_active" class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring-1 focus:ring-[#800c3c] outline-none">
                    <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ old('is_active', 1) == 0 ? 'selected' : '' }}>No</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-[#59565e]">Link</label>
            <input type="text" name="menulink" value="{{ old('menulink') }}"
                class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring-1 focus:ring-[#800c3c] outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-[#59565e]">Icon (SVG HTML)</label>
            <textarea name="icon" rows="3"
                class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring-1 focus:ring-[#800c3c] outline-none font-mono text-xs">{{ old('icon') }}</textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('menus.index') }}" class="px-4 py-2 rounded-lg border border-slate-200 hover:bg-[#dcd9e0] text-sm font-medium text-[#59565e]">Cancel</a>
            <button type="submit" class="px-4 py-2 rounded-xl bg-[#800c3c] hover:bg-[#60072b] text-white text-sm font-medium transition-colors">Save</button>
        </div>
    </form>
</div>
@endsection