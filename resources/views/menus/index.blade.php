@extends('layouts.app')

@section('title', 'Menu Management')
@section('page-title', 'Menu Management')

@section('content')
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
    <div class="p-4 lg:p-6 border-b border-slate-200 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-slate-800">Menus</h2>
        @if ($userAccess['fadd'])
            <a href="{{ route('menus.create') }}" class="px-4 py-2 rounded-xl bg-[#800c3c] hover:bg-[#60072b] text-white text-sm font-medium transition-colors">+ New Menu</a>
        @endif
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="sticky top-0 bg-[#f8fafc] text-slate-600 font-semibold border-b border-slate-200">
                <tr>
                    <th class="px-4 lg:px-6 py-3 font-medium">Code</th>
                    <th class="px-4 lg:px-6 py-3 font-medium">Name</th>
                    <th class="px-4 lg:px-6 py-3 font-medium">Parent</th>
                    <th class="px-4 lg:px-6 py-3 font-medium">Type</th>
                    <th class="px-4 lg:px-6 py-3 font-medium">Link</th>
                    <th class="px-4 lg:px-6 py-3 font-medium">Order</th>
                    <th class="px-4 lg:px-6 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach ($menus as $menu)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-4 lg:px-6 py-3 text-slate-600">{{ $menu->menucode }}</td>
                        <td class="px-4 lg:px-6 py-3 font-medium text-slate-800">{{ $menu->menuname }}</td>
                        <td class="px-4 lg:px-6 py-3 text-slate-600">{{ $menu->menuparent ?: '-' }}</td>
                        <td class="px-4 lg:px-6 py-3 capitalize text-slate-600">{{ $menu->menutype }}</td>
                        <td class="px-4 lg:px-6 py-3 text-slate-500">{{ $menu->menulink ?: '-' }}</td>
                        <td class="px-4 lg:px-6 py-3 text-slate-600">{{ $menu->idx }}</td>
                        <td class="px-4 lg:px-6 py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                @if ($userAccess['fedit'])
                                    <a href="{{ route('menus.edit', $menu) }}" class="text-slate-400 hover:text-blue-600 hover:bg-blue-50 p-1.5 rounded-md" title="Edit">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                @endif
                                @if ($userAccess['fdelete'])
                                    <form action="{{ route('menus.destroy', $menu) }}" method="POST" class="inline" onclick="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-400 hover:text-red-600 hover:bg-red-50 p-1.5 rounded-md" title="Deactivate">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
