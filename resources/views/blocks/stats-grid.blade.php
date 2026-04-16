<section class="stats-section">
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="section-title">{{ $data['title'] }}</h2>
        @endif
        <div class="stats-grid">
            @foreach($data['stats'] ?? [] as $stat)
                <div class="stat-card">
                    <div class="stat-number">{{ $stat['number'] ?? '0' }}</div>
                    <div class="stat-label">{!! str_replace("\n", '<br>', e($stat['label'] ?? '')) !!}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
