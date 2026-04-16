@php
    $variant = $data['variant'] ?? 'default';
@endphp

@if($variant === 'historia')
    <section class="historia-intro-banner">
        <div class="container">
            @if(!empty($data['title']))
                <h1 class="historia-intro-title">{{ $data['title'] }}</h1>
            @endif
            @if(!empty($data['text']))
                <p class="historia-intro-text">{{ $data['text'] }}</p>
            @endif
        </div>
    </section>
@elseif($variant === 'impl')
    <section class="impl-intro">
        <div class="container">
            <div class="impl-intro-content">
                @if(!empty($data['title']))
                    <h2 class="impl-section-title">{{ $data['title'] }}</h2>
                @endif
                @if(!empty($data['text']))
                    <p class="impl-intro-text">{!! $data['text'] !!}</p>
                @endif
            </div>
        </div>
    </section>
@else
    <section class="intro-section" style="padding: 3rem 0; text-align: center;">
        <div class="container">
            @if(!empty($data['title']))
                <h2 class="section-title">{{ $data['title'] }}</h2>
            @endif
            @if(!empty($data['text']))
                <p class="intro-text" style="max-width: 800px; margin: 0 auto; font-size: 1.1rem; color: #555;">{!! $data['text'] !!}</p>
            @endif
        </div>
    </section>
@endif
