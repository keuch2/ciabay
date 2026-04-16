@extends('layouts.admin', ['title' => 'Seguimiento'])

@section('content')
<form action="{{ route('admin.tracking.update') }}" method="POST" class="max-w-4xl">
    @csrf @method('PUT')

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-lg mb-6 text-sm">
        <p class="font-semibold mb-1">Atención</p>
        <p>El contenido de estos campos se inserta tal cual en el HTML del sitio público. Solo pegá códigos oficiales de Google, Meta u otros proveedores que conozcas. Código malicioso pegado acá compromete a todos los visitantes del sitio.</p>
    </div>

    {{-- HEAD --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-1">Código para el &lt;head&gt;</h3>
        <p class="text-xs text-gray-500 mb-3">Se inserta dentro del <code class="bg-gray-100 px-1 rounded">&lt;head&gt;</code> de todas las páginas públicas, antes del cierre. Acá van: Google Tag Manager (snippet principal), Google Analytics (gtag.js), Meta Pixel, HotJar, Microsoft Clarity.</p>
        <textarea name="tracking_head_html" rows="14"
                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs font-mono"
                  placeholder="<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){...})(window,document,'script','dataLayer','GTM-XXXXXXX');</script>
<!-- End Google Tag Manager -->

<!-- Google tag (gtag.js) -->
<script async src='https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX'></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-XXXXXXXXXX');
</script>

<!-- Meta Pixel -->
<script>
  !function(f,b,e,v,n,t,s){...}
  fbq('init', '0000000000000000');
  fbq('track', 'PageView');
</script>">{{ old('tracking_head_html', $headHtml) }}</textarea>
    </div>

    {{-- BODY open --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-1">Código al abrir &lt;body&gt;</h3>
        <p class="text-xs text-gray-500 mb-3">Se inserta justo después del <code class="bg-gray-100 px-1 rounded">&lt;body&gt;</code>. Típicamente el fragmento <code class="bg-gray-100 px-1 rounded">&lt;noscript&gt;</code> de Google Tag Manager va acá.</p>
        <textarea name="tracking_body_html" rows="6"
                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs font-mono"
                  placeholder="<!-- Google Tag Manager (noscript) -->
<noscript><iframe src='https://www.googletagmanager.com/ns.html?id=GTM-XXXXXXX' height='0' width='0' style='display:none;visibility:hidden'></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->">{{ old('tracking_body_html', $bodyHtml) }}</textarea>
    </div>

    {{-- FOOTER (before </body>) --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-1">Código al cerrar &lt;body&gt; (footer)</h3>
        <p class="text-xs text-gray-500 mb-3">Se inserta justo antes del <code class="bg-gray-100 px-1 rounded">&lt;/body&gt;</code>. Ideal para widgets de chat (Tawk.to, Intercom), tags de remarketing diferido o cualquier script no crítico.</p>
        <textarea name="tracking_footer_html" rows="8"
                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs font-mono"
                  placeholder="<!-- Tawk.to -->
<script type='text/javascript'>
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){ ... })();
</script>">{{ old('tracking_footer_html', $footerHtml) }}</textarea>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">
            Guardar códigos de seguimiento
        </button>
        <a href="{{ url('/') }}" target="_blank" rel="noopener" class="text-sm text-blue-600 hover:text-blue-800">Ver sitio público →</a>
    </div>
</form>
@endsection
