<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Admin' }} - Ciabay CMS</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex" x-data="{ sidebarOpen: true }">
            <!-- Sidebar -->
            <aside class="bg-gray-900 text-white transition-all duration-300 flex-shrink-0"
                   :class="sidebarOpen ? 'w-64' : 'w-16'"
                   style="min-height: 100vh;">
                <!-- Logo -->
                <div class="flex items-center justify-between p-4 border-b border-gray-700">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2" x-show="sidebarOpen">
                        <span class="text-lg font-bold text-white">Ciabay CMS</span>
                    </a>
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>

                <!-- Nav Links -->
                <nav class="mt-4 space-y-1 px-2">
                    @php
                        $navItems = [
                            ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'permission' => null],
                            ['route' => 'admin.pages.index', 'label' => 'Páginas', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'permission' => 'pages.view'],
                            ['route' => 'admin.navigation.index', 'label' => 'Navegación', 'icon' => 'M4 6h16M4 12h16m-7 6h7', 'permission' => 'navigation.manage'],
                            ['route' => 'admin.branches.index', 'label' => 'Sucursales', 'icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z', 'permission' => 'branches.view'],
                            ['route' => 'admin.brands.index', 'label' => 'Marcas', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z', 'permission' => 'brands.view'],
                            ['route' => 'admin.products.index', 'label' => 'Productos', 'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z', 'permission' => 'products.view'],
                            ['route' => 'admin.product-categories.index', 'label' => 'Cat. Productos', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z', 'permission' => 'products.view'],
                            ['route' => 'admin.orders.index', 'label' => 'Pedidos', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'permission' => 'orders.view'],
                            ['route' => 'admin.blog.posts.index', 'label' => 'Blog', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z', 'permission' => 'blog.view'],
                            ['route' => 'admin.contacts.index', 'label' => 'Contactos', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'permission' => 'contacts.view'],
                            ['route' => 'admin.media.index', 'label' => 'Media', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'permission' => 'media.view'],
                            ['route' => 'admin.settings.index', 'label' => 'Configuración', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', 'permission' => 'settings.manage'],
                            ['route' => 'admin.theme.edit', 'label' => 'Tema', 'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01', 'permission' => 'settings.manage'],
                            ['route' => 'admin.users.index', 'label' => 'Usuarios', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'permission' => 'users.view'],
                        ];
                    @endphp

                    @foreach($navItems as $item)
                        @if($item['permission'] === null || auth()->user()->hasRole('super-admin') || auth()->user()->can($item['permission']))
                            <a href="{{ route($item['route']) }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors
                                      {{ request()->routeIs($item['route'] . '*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                                </svg>
                                <span x-show="sidebarOpen" class="truncate">{{ $item['label'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </nav>

                <!-- User info at bottom -->
                <div class="absolute bottom-0 w-64 p-4 border-t border-gray-700" x-show="sidebarOpen">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-sm font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ auth()->user()->roles->first()?->name ?? 'Sin rol' }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full text-left text-xs text-gray-400 hover:text-white transition-colors">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Top Bar -->
                <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-800">@yield('page-title', $title ?? 'Dashboard')</h1>
                        @hasSection('page-subtitle')
                            <p class="text-sm text-gray-500 mt-1">@yield('page-subtitle')</p>
                        @endif
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="{{ url('/') }}" target="_blank" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Ver sitio
                        </a>
                    </div>
                </header>

                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mx-6 mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mx-6 mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm" x-data="{ show: true }" x-show="show">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Page Content -->
                <main class="flex-1 p-6">
                    @yield('content')
                </main>
            </div>
        </div>

        {{-- Global media library picker modal, listens for `open-media-picker` events --}}
        @include('admin.partials.media-picker')

        @stack('scripts')
    </body>
</html>
