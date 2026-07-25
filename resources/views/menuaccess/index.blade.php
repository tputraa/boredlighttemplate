@extends('layouts.app')

@section('title', 'Menu Access')
@section('page-title', 'Menu Access')

@section('content')
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
    <div class="p-4 lg:p-6 border-b border-slate-200">
        <h2 class="text-lg font-semibold text-slate-800">Role Permissions</h2>
        <p class="text-sm text-slate-500">Select a role to manage its menu access rights.</p>
    </div>

    <form action="{{ route('menuaccess.store') }}" method="POST">
        @csrf

        <div class="p-4 lg:p-6 border-b border-slate-200">
            <label class="block text-sm font-medium text-slate-700 mb-2">Role</label>
            <select name="user_group_id" id="roleSelect" class="w-full md:w-80 rounded-lg border border-slate-200 px-3 py-2 focus:border-[#800c3c] focus:ring focus:ring-[#800c3c]/20 outline-none">
                @foreach ($roles as $role)
                    <option value="{{ $role->roleid }}" {{ $selectedRole == $role->roleid ? 'selected' : '' }}>{{ $role->rolename }}</option>
                @endforeach
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="sticky top-0 bg-[#f8fafc] text-slate-600 font-semibold border-b border-slate-200">
                    <tr>
                        <th class="px-4 lg:px-6 py-3 font-medium">Menu</th>
                        <th class="px-4 lg:px-6 py-3 font-medium text-center">View</th>
                        <th class="px-4 lg:px-6 py-3 font-medium text-center">Add</th>
                        <th class="px-4 lg:px-6 py-3 font-medium text-center">Edit</th>
                        <th class="px-4 lg:px-6 py-3 font-medium text-center">Delete</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($menus as $menu)
                        @php
                            $key = $selectedRole . ':' . $menu->menucode;
                            $row = $access->get($key);
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-4 lg:px-6 py-3 font-medium text-slate-700">
                                {{ $menu->menuname }}
                                @if ($menu->menuparent)
                                    <span class="ml-2 text-xs text-slate-400">(child)</span>
                                @endif
                            </td>
                            <td class="px-4 lg:px-6 py-3 text-center">
                                <input type="checkbox" name="permissions[{{ $menu->menucode }}][fview]" value="1" {{ $row?->fview ? 'checked' : '' }}>
                            </td>
                            <td class="px-4 lg:px-6 py-3 text-center">
                                <input type="checkbox" name="permissions[{{ $menu->menucode }}][fadd]" value="1" {{ $row?->fadd ? 'checked' : '' }}>
                            </td>
                            <td class="px-4 lg:px-6 py-3 text-center">
                                <input type="checkbox" name="permissions[{{ $menu->menucode }}][fedit]" value="1" {{ $row?->fedit ? 'checked' : '' }}>
                            </td>
                            <td class="px-4 lg:px-6 py-3 text-center">
                                <input type="checkbox" name="permissions[{{ $menu->menucode }}][fdelete]" value="1" {{ $row?->fdelete ? 'checked' : '' }}>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 lg:p-6 border-t border-slate-200 flex items-center justify-end">
            <button type="submit" class="px-6 py-2 rounded-xl bg-[#800c3c] hover:bg-[#60072b] text-white text-sm font-medium transition-colors">Save Permissions</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const select = document.getElementById('roleSelect');
        if (select) {
            select.addEventListener('change', () => {
                window.location.href = '{{ route('menuaccess.index') }}?role=' + select.value;
            });
        }
    });
</script>
@endsection
