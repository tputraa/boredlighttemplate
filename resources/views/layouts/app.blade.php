<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <style>
        :root {
            --sidebar-bg: #e9e7ec;
            --sidebar-text: #59565e;
            --sidebar-active: #dcd9e0;
            --sidebar-active-text: #1c1a1e;
            --sidebar-hover-bg: #dcd9e0;
            --main-bg: #f4f3f6;
            --card-bg: #ffffff;
            --border: #dedbe2;
            --primary: #800c3c;
            --primary-dark: #60072b;
        }
        [x-cloak] { display: none !important; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f4f3f6] text-[#1c1a1e] antialiased">
    <div
        x-data="sidebar()"
        x-init="init()"
        class="flex min-h-screen"
    >
        <!-- Sidebar -->
        <aside
            :class="sidebarOpen ? 'w-64' : 'w-16'"
            class="bg-[#e9e7ec] text-[#59565e] flex flex-col transition-all duration-300 fixed inset-y-0 left-0 z-40 lg:relative h-screen border-r border-[#dedbe2]"
        >
            <!-- Logo -->
            <div class="h-16 flex items-center px-4 border-b border-[#dedbe2]">
                <div class="w-8 h-8 rounded-lg bg-[#800c3c] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <span
                    x-show="sidebarOpen"
                    x-transition
                    class="ml-3 font-semibold text-lg whitespace-nowrap text-[#1c1a1e]"
                >CorpApp</span>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-4 px-2 space-y-1 [&>*]:relative">
                @php
                    $activeParentCode = $activeParentMenuCode ?? null;
                @endphp
                @foreach ($menus as $menu)
                    @if (!empty($menu['children']) || $menu['menutype'] === 'link')
                        <div>
                            @if ($menu['menutype'] === 'parent' && !empty($menu['children']))
                                @php
                                    $hasActiveChild = $activeParentCode === $menu['menucode'];
                                @endphp
                                <button
                                    @click="toggleMenu({{ $menu['menucode'] }})"
                                    class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg hover:bg-[#dcd9e0] hover:text-[#1c1a1e] transition-colors group"
                                    :class="sidebarOpen 
                                        ? (openMenus.includes({{ $menu['menucode'] }}) ? 'bg-[#dcd9e0] text-[#1c1a1e] font-semibold' : '') 
                                        : ({{ $hasActiveChild ? 'true' : 'false' }} ? 'bg-[#dcd9e0] text-[#1c1a1e] font-semibold' : '')"
                                    :title="!sidebarOpen ? '{{ $menu['menuname'] }}' : ''"
                                >
                                    <div class="flex items-center min-w-0">
                                        <span class="shrink-0 text-[#59565e] group-hover:text-[#1c1a1e]">
                                            {!! $menu['icon'] !!}
                                        </span>
                                        <span
                                            x-show="sidebarOpen"
                                            x-transition
                                            class="ml-3 truncate"
                                        >{{ $menu['menuname'] }}</span>
                                    </div>
                                    <span x-show="sidebarOpen" x-transition>
                                        <svg
                                            :class="openMenus.includes({{ $menu['menucode'] }}) ? 'rotate-180' : ''"
                                            class="w-4 h-4 text-[#59565e] transition-transform"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </span>
                                </button>

                                <div
                                    x-show="openMenus.includes({{ $menu['menucode'] }})"
                                    :class="sidebarOpen ? 'relative mt-1 space-y-1 pl-4 border-l border-[#dedbe2] ml-4' : 'fixed z-50 left-16 mt-0 ml-0 py-2 bg-white rounded-lg shadow-xl border border-[#dedbe2] min-w-[200px]'"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    @click.outside="sidebarOpen ? true : openMenus = openMenus.filter(c => c !== {{ $menu['menucode'] }})"
                                    x-cloak
                                >
                                    @foreach ($menu['children'] as $child)
                                        @php
                                            $isActive = request()->is(trim($child['menulink'], '/').'*');
                                        @endphp
                                        <a
                                            href="{{ $child['menulink'] }}"
                                            :class="sidebarOpen 
                                                ? 'flex items-center px-3 py-2 rounded-lg text-sm {{ $isActive ? 'bg-[#dcd9e0] text-[#1c1a1e] font-semibold' : 'text-[#59565e] hover:text-[#1c1a1e] hover:bg-[#dcd9e0]' }}' 
                                                : 'flex items-center px-4 py-2.5 text-sm whitespace-nowrap {{ $isActive ? 'bg-[#dcd9e0] text-[#1c1a1e] font-semibold' : 'text-[#59565e] hover:bg-[#dcd9e0] hover:text-[#1c1a1e]' }}'"
                                            @click="sidebarOpen ? true : openMenus = openMenus.filter(c => c !== {{ $menu['menucode'] }})"
                                        >
                                            <span class="shrink-0">{!! $child['icon'] !!}</span>
                                            <span class="ml-3 truncate">{{ $child['menuname'] }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <a
                                    href="{{ $menu['menulink'] }}"
                                    class="flex items-center px-3 py-2.5 rounded-lg transition-colors group {{ request()->is(trim($menu['menulink'], '/')) ? 'bg-[#dcd9e0] text-[#1c1a1e] font-semibold' : 'text-[#59565e] hover:text-[#1c1a1e] hover:bg-[#dcd9e0]' }}"
                                    :title="!sidebarOpen ? '{{ $menu['menuname'] }}' : ''"
                                >
                                    <span class="shrink-0 text-[#59565e] group-hover:text-[#1c1a1e]">
                                        {!! $menu['icon'] !!}
                                    </span>
                                    <span
                                        x-show="sidebarOpen"
                                        x-transition
                                        class="ml-3 truncate"
                                    >{{ $menu['menuname'] }}</span>
                                </a>
                            @endif
                        </div>
                    @endif
                @endforeach
            </nav>

            @auth
            <div class="mt-auto border-t border-[#dedbe2] p-3">
                <div
                    class="flex items-center"
                    :class="sidebarOpen ? 'justify-between' : 'justify-center'"
                >
                    <a href="{{ route('users.edit', Auth::user()) }}" class="flex items-center min-w-0 group" title="Edit profile">
                        <div class="w-8 h-8 rounded-full bg-[#800c3c]/10 text-[#800c3c] flex items-center justify-center shrink-0">
                            <span class="text-xs font-bold">{{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}</span>
                        </div>
                        <div x-show="sidebarOpen" x-transition class="ml-3 min-w-0">
                            <p class="text-sm font-medium truncate text-[#1c1a1e] group-hover:text-[#800c3c]">{{ Auth::user()->name ?? 'User' }}</p>
                            <p class="text-xs text-[#59565e] truncate">{{ Auth::user()->email ?? '' }}</p>
                        </div>
                    </a>
                    <form x-show="sidebarOpen" x-transition method="POST" action="{{ route('logout') }}" class="shrink-0 ml-2" x-cloak>
                        @csrf
                        <button type="submit" class="p-1.5 rounded-lg hover:bg-[#dcd9e0] text-[#59565e] hover:text-[#1c1a1e]" title="Logout">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            @endauth
        </aside>

        <!-- Mobile overlay -->
        <div
            x-show="sidebarOpen"
            @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/40 z-30 lg:hidden"
            x-transition.opacity
        ></div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Header -->
            <header class="h-16 bg-white border-b border-[#dedbe2] flex items-center px-4 lg:px-6 sticky top-0 z-20 shadow-sm">
                <button
                    @click="sidebarOpen = !sidebarOpen"
                    class="p-2 rounded-lg hover:bg-[#dcd9e0] text-[#59565e]"
                    aria-label="Toggle sidebar"
                >
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 class="ml-4 text-lg font-semibold text-[#1c1a1e] truncate">@yield('page-title', 'Dashboard')</h1>
            </header>

            <!-- Page content -->
            <main class="flex-1 p-4 lg:p-6">
                @if (session('success'))
                    <div class="mb-4 px-4 py-3 rounded-lg bg-[#e53e3e]/10 text-[#e53e3e] border border-[#e53e3e]/20">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function sidebar() {
            return {
                sidebarOpen: true,
                openMenus: [],
                init() {
                    const stored = localStorage.getItem('sidebarOpen');
                    this.sidebarOpen = stored === null ? true : stored === 'true';

                    this.$watch('sidebarOpen', value => localStorage.setItem('sidebarOpen', value));

                    // Only auto-open active parent menu when sidebar is expanded
                    if (this.sidebarOpen) {
                        const activeParent = @json($activeParentMenuCode ?? null);
                        if (activeParent) {
                            this.openMenus = [activeParent];
                        }
                    }
                },
                toggleMenu(code) {
                    if (this.openMenus.includes(code)) {
                        this.openMenus = this.openMenus.filter(c => c !== code);
                    } else {
                        this.openMenus.push(code);
                    }
                }
            };
        }
    </script>
</body>
</html>