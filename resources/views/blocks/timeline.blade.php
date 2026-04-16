@php
    $variant = $data['variant'] ?? 'default';
    $sectionClass = $variant === 'historia' ? 'historia-timeline' : 'timeline-section';
    $titleClass = $variant === 'historia' ? 'historia-section-title historia-section-title--center' : 'section-title';
@endphp
<section class="{{ $sectionClass }}" @if($variant !== 'historia') style="padding: 4rem 0;" @endif>
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="{{ $titleClass }}">{{ $data['title'] }}</h2>
        @endif
        <div class="timeline">
            @foreach($data['events'] ?? [] as $event)
                <div class="timeline-item">
                    @if($variant === 'historia' && !empty($event['image']))
                        <div class="timeline-logo">
                            <img src="{{ asset($event['image']) }}" alt="{{ $event['title'] ?? $event['year'] ?? '' }}">
                        </div>
                        <div class="timeline-content">
                            @if(!empty($event['year']))
                                <div class="timeline-year">{{ $event['year'] }}</div>
                            @endif
                            @if(!empty($event['description']))
                                <p class="timeline-text">{{ $event['description'] }}</p>
                            @endif
                        </div>
                    @else
                        <div class="timeline-marker">
                            <span class="timeline-year">{{ $event['year'] ?? '' }}</span>
                        </div>
                        <div class="timeline-content">
                            @if(!empty($event['title']))
                                <h3>{{ $event['title'] }}</h3>
                            @endif
                            @if(!empty($event['description']))
                                <p>{{ $event['description'] }}</p>
                            @endif
                            @if(!empty($event['image']))
                                <img src="{{ asset($event['image']) }}" alt="{{ $event['title'] ?? '' }}">
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
