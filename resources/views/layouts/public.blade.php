<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $resolveBrandingImg = function ($value, $fallback = null) {
            if (!$value) return $fallback;
            if (preg_match('#^(https?:)?//#', $value)) return $value;
            $v = ltrim($value, '/');
            if (str_starts_with($v, 'assets/') || str_starts_with($v, 'storage/')) return asset($v);
            return asset('storage/' . $v);
        };
        $siteLogo = $resolveBrandingImg(\App\Models\Setting::get('site_logo'), asset('assets/images/logo.jpg'));
        $siteFavicon = $resolveBrandingImg(\App\Models\Setting::get('site_favicon'));
    @endphp

    @if($siteFavicon)
        <link rel="icon" href="{{ $siteFavicon }}">
        <link rel="shortcut icon" href="{{ $siteFavicon }}">
    @endif

    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ $metaDescription ?? \App\Models\Setting::get('site_description', 'Ciabay - Agricultura en buenas manos.') }}">
    <meta name="keywords" content="Ciabay, maquinaria agrícola Paraguay, Case IH Paraguay, tractores agrícolas, cosechadoras, implementos agrícolas, insumos agrícolas, agricultura de precisión, repuestos agrícolas, postventa agrícola">
    <meta name="author" content="Ciabay S.A.">
    <meta name="robots" content="index, follow">
    <meta name="language" content="Spanish">
    <meta name="geo.region" content="PY">
    <meta name="geo.placename" content="Paraguay">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $metaTitle ?? 'Ciabay - Agricultura en buenas manos | Maquinaria Agrícola Paraguay' }}">
    <meta property="og:description" content="{{ $metaDescription ?? \App\Models\Setting::get('site_description') }}">
    <meta property="og:image" content="{{ $ogImage ?? $siteLogo }}">
    <meta property="og:locale" content="es_PY">
    <meta property="og:site_name" content="Ciabay">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $metaTitle ?? 'Ciabay - Agricultura en buenas manos | Maquinaria Agrícola Paraguay' }}">
    <meta name="twitter:description" content="{{ $metaDescription ?? \App\Models\Setting::get('site_description') }}">
    <meta name="twitter:image" content="{{ $ogImage ?? $siteLogo }}">
    <meta name="twitter:site" content="@@ciabaysa">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Structured Data - Organization -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Organization",
      "name": "Ciabay S.A.",
      "alternateName": "Ciabay",
      "url": "{{ url('/') }}",
      "logo": "{{ $siteLogo }}",
      "description": "Agricultura en buenas manos. Distribuidores oficiales de maquinaria agrícola Case IH en Paraguay.",
      "slogan": "Agricultura en buenas manos",
      "foundingDate": "1993",
      "contactPoint": {
        "@@type": "ContactPoint",
        "telephone": "+595-983-730082",
        "contactType": "customer service",
        "areaServed": "PY",
        "availableLanguage": ["es", "Guarani"]
      },
      "sameAs": [
        "{{ \App\Models\Setting::get('social_facebook', 'https://www.facebook.com/ciabaysa') }}",
        "{{ \App\Models\Setting::get('social_instagram', 'https://www.instagram.com/ciabaysa') }}",
        "{{ \App\Models\Setting::get('social_youtube', 'https://www.youtube.com/@ciabay7756') }}",
        "{{ \App\Models\Setting::get('social_tiktok', 'https://www.tiktok.com/@ciabaysa') }}"
      ]
    }
    </script>

    <!-- AEO Meta -->
    <meta name="abstract" content="Ciabay es líder en distribución de maquinaria agrícola Case IH en Paraguay con 31+ años de experiencia, 8 sucursales, 300+ colaboradores y 120+ técnicos de postventa.">
    <meta name="topic" content="Maquinaria Agrícola, Agricultura de Precisión, Case IH Paraguay">
    <meta name="classification" content="Business, Agriculture, Machinery">
    <meta name="coverage" content="Paraguay">

    @hasSection('schema')
        @yield('schema')
    @endif

    <title>{{ $metaTitle ?? 'Ciabay - Agricultura en buenas manos | Maquinaria Agrícola Case IH Paraguay' }}</title>

    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @foreach(\App\Http\Controllers\Admin\ThemeController::fontImports() as $fontUrl)
        <link href="{{ $fontUrl }}" rel="stylesheet">
    @endforeach

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

    @php $themeCss = \App\Http\Controllers\Admin\ThemeController::cssVariables(); @endphp
    @if($themeCss)
        <style id="theme-overrides">{!! $themeCss !!}</style>
    @endif

    <!-- Alpine.js for interactive components (product gallery, etc.) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')

    {{-- Admin-managed custom CSS: global + section (store) + entity --}}
    @php
        $__globalCustomCss = \App\Models\Setting::get('global_custom_css');
        $__sectionCustomCss = request()->is('tienda-online*')
            ? \App\Models\Setting::get('store_custom_css')
            : null;
    @endphp
    @if($__globalCustomCss)
        <style id="global-custom-css">{!! $__globalCustomCss !!}</style>
    @endif
    @if($__sectionCustomCss)
        <style id="section-custom-css">{!! $__sectionCustomCss !!}</style>
    @endif
    @if(!empty($customCss))
        <style id="entity-custom-css">{!! $customCss !!}</style>
    @endif

    {{-- Admin-managed tracking codes (GTM, Meta Pixel, HotJar, etc.) --}}
    @php $trackingHead = \App\Models\Setting::get('tracking_head_html'); @endphp
    @if($trackingHead)
        {!! $trackingHead !!}
    @endif
</head>
<body>
    @php $trackingBody = \App\Models\Setting::get('tracking_body_html'); @endphp
    @if($trackingBody)
        {!! $trackingBody !!}
    @endif

    @php $__isDraftPreview = !empty($isDraft ?? null); @endphp
    @if($__isDraftPreview)
        <div style="position:sticky;top:0;z-index:9999;background:#f59e0b;color:#1a1a1a;font-weight:700;text-align:center;padding:0.6rem 1rem;font-size:0.9rem;letter-spacing:0.05em;text-transform:uppercase;box-shadow:0 2px 8px rgba(0,0,0,0.15);">
            Vista previa — Contenido en borrador / inactivo (solo visible para administradores)
        </div>
    @endif

    <!-- Main Header -->
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="logo">
                    <img src="{{ $siteLogo }}" alt="Ciabay Logo">
                </a>

                <!-- Navigation Menu -->
                <nav class="main-nav" id="mainNav">
                    @php
                        $headerNav = \App\Models\Navigation::where('location', 'header')->with('items.children')->first();
                    @endphp
                    <ul class="nav-list">
                        @if($headerNav)
                            @foreach($headerNav->items as $item)
                                <li class="nav-item @if($item->children->count()) has-submenu @endif">
                                    <a href="{{ $item->resolved_url }}" class="nav-link" @if($item->target !== '_self') target="{{ $item->target }}" rel="noopener noreferrer" @endif>{{ $item->label }}</a>
                                    @if($item->children->count())
                                        <ul class="submenu">
                                            @foreach($item->children as $child)
                                                <li><a href="{{ $child->resolved_url }}" class="submenu-link" @if($child->target !== '_self') target="{{ $child->target }}" rel="noopener noreferrer" @endif>{{ $child->label }}</a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        @else
                            <li class="nav-item">
                                <a href="{{ url('historia') }}" class="nav-link">SOBRE CIABAY</a>
                                <ul class="submenu">
                                    <li><a href="{{ url('historia') }}" class="submenu-link">Historia</a></li>
                                    <li><a href="{{ url('mision-vision-valores') }}" class="submenu-link">Misión, Visión y Valores</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('sucursales') }}" class="nav-link">SUCURSALES</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.ciabayusados.com" class="nav-link" target="_blank" rel="noopener noreferrer">USADOS</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('contacto') }}" class="nav-link">CONTACTO</a>
                            </li>
                        @endif
                    </ul>
                </nav>

                <!-- Search Button -->
                <button class="search-btn" id="searchBtn" aria-label="Buscar" style="display: none;">
                    <img src="{{ asset('assets/images/search.png') }}" alt="Buscar">
                </button>

                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Menú">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </header>

    <!-- Search Overlay -->
    <div class="search-overlay" id="searchOverlay">
        <div class="search-container">
            <button class="search-close" id="searchClose" aria-label="Cerrar búsqueda">&times;</button>
            <form class="search-form" role="search">
                <input type="search" class="search-input" placeholder="¿Qué estás buscando?" aria-label="Buscar">
                <button type="submit" class="search-submit">Buscar</button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column footer-logo-column">
                    <img src="{{ $siteLogo }}" alt="Ciabay Logo" class="footer-logo-img">
                    <p class="footer-description">{{ \App\Models\Setting::get('footer_description', 'Soluciones agrícolas de calidad con más de 30 años de experiencia.') }}</p>
                </div>

                @php
                    $footerNav = \App\Models\Navigation::where('location', 'footer')->with('items.children')->first();
                @endphp
                @if($footerNav)
                    @foreach($footerNav->items as $item)
                        <div class="footer-column">
                            @if($item->label !== '-')
                                <h3 class="footer-column-title">{{ $item->label }}</h3>
                            @endif
                            @if($item->children->count())
                                <ul class="footer-nav-list">
                                    @foreach($item->children as $child)
                                        <li><a href="{{ $child->resolved_url }}" class="footer-link" @if($child->target !== '_self') target="{{ $child->target }}" rel="noopener noreferrer" @endif>{{ $child->label }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="footer-column">
                        <ul class="footer-nav-list">
                            <li><a href="{{ url('historia') }}" class="footer-link">Historia</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <ul class="footer-nav-list">
                            <li><a href="{{ url('sucursales') }}" class="footer-link">Sucursales</a></li>
                            <li><a href="https://www.ciabayusados.com" target="_blank" rel="noopener noreferrer" class="footer-link">Usados</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <ul class="footer-nav-list">
                            <li><a href="{{ url('contacto') }}" class="footer-link">Contacto</a></li>
                        </ul>
                        <ul class="footer-nav-list">
                            <li><a href="https://grupo.ciabay.com/trabajaenciabay" target="_blank" rel="noopener noreferrer" class="footer-link">Trabaja en Ciabay</a></li>
                        </ul>
                    </div>
                @endif

                <div class="footer-column">
                    <h3 class="footer-column-title">Síguenos</h3>
                    <div class="social-icons">
                        @php
                            $socials = [
                                ['key' => 'social_facebook', 'label' => 'Facebook', 'icon' => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z'],
                                ['key' => 'social_instagram', 'label' => 'Instagram', 'icon' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z'],
                                ['key' => 'social_youtube', 'label' => 'YouTube', 'icon' => 'M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z'],
                                ['key' => 'social_tiktok', 'label' => 'TikTok', 'icon' => 'M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z'],
                            ];
                        @endphp
                        @foreach($socials as $social)
                            @php $url = \App\Models\Setting::get($social['key']); @endphp
                            @if($url)
                                <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="social-icon" aria-label="{{ $social['label'] }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="{{ $social['icon'] }}"/>
                                    </svg>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p class="footer-copyright">&copy; {{ date('Y') }} Ciabay. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    @php $whatsapp = \App\Models\Setting::get('whatsapp_number', '595983730082'); @endphp
    <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="whatsapp-float" aria-label="Chat por WhatsApp">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="currentColor">
            <path d="M27.281 4.65C24.318 1.686 20.396 0 16.238 0 7.378 0 .116 7.261.116 16.122c0 2.84.742 5.616 2.157 8.073L0 32l8.045-2.11a16.087 16.087 0 0 0 7.686 1.959h.007c8.853 0 16.116-7.261 16.116-16.116 0-4.31-1.679-8.364-4.573-11.073zM16.238 29.47h-.006a13.407 13.407 0 0 1-6.823-1.868l-.49-.29-5.075 1.33 1.354-4.95-.318-.508a13.363 13.363 0 0 1-2.05-7.134c0-7.401 6.025-13.426 13.433-13.426 3.588 0 6.96 1.4 9.506 3.946 2.546 2.546 3.946 5.918 3.946 9.506-.007 7.408-6.032 13.433-13.477 13.433zm7.362-10.05c-.404-.202-2.39-1.179-2.76-1.313-.37-.134-.64-.202-.91.202-.27.404-1.046 1.313-1.283 1.583-.236.27-.472.303-.876.101-.404-.202-1.703-.628-3.244-2.001-1.199-1.069-2.008-2.389-2.244-2.793-.236-.404-.025-.623.177-.824.182-.182.404-.472.606-.708.202-.236.27-.404.404-.674.134-.27.067-.505-.034-.707-.101-.202-.91-2.192-1.246-3.001-.328-.788-.662-.681-.91-.694-.236-.012-.505-.015-.775-.015s-.708.101-1.078.505c-.37.404-1.413 1.38-1.413 3.37 0 1.99 1.447 3.914 1.649 4.184.202.27 2.84 4.336 6.879 6.078.961.415 1.711.663 2.296.849.965.307 1.843.263 2.537.16.774-.116 2.39-.977 2.726-1.921.337-.944.337-1.753.236-1.921-.101-.168-.37-.27-.775-.472z"/>
        </svg>
    </a>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')

    {{-- Admin-managed custom JS: global + section (store) + entity --}}
    @php
        $__globalCustomJs = \App\Models\Setting::get('global_custom_js');
        $__sectionCustomJs = request()->is('tienda-online*')
            ? \App\Models\Setting::get('store_custom_js')
            : null;
    @endphp
    @if($__globalCustomJs)
        <script id="global-custom-js">{!! $__globalCustomJs !!}</script>
    @endif
    @if($__sectionCustomJs)
        <script id="section-custom-js">{!! $__sectionCustomJs !!}</script>
    @endif
    @if(!empty($customJs))
        <script id="entity-custom-js">{!! $customJs !!}</script>
    @endif

    @php $trackingFooter = \App\Models\Setting::get('tracking_footer_html'); @endphp
    @if($trackingFooter)
        {!! $trackingFooter !!}
    @endif
</body>
</html>
