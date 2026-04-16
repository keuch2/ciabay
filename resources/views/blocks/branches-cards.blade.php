@php
    $source = $data['source'] ?? 'branches';
    if ($source === 'branches') {
        $items = \App\Models\Branch::active()->orderBy('sort_order')->get()->map(function ($b) {
            return [
                'name' => $b->name,
                'image' => $b->image,
                'address' => trim(implode(' — ', array_filter([$b->address, $b->city, $b->department]))),
            ];
        });
    } else {
        $items = collect($data['items'] ?? []);
    }
    $resolveImg = function ($img) {
        if (!$img) return null;
        if (preg_match('#^(https?:)?//#', $img)) return $img;
        if (str_starts_with($img, 'assets/') || str_starts_with($img, 'storage/')) return asset($img);
        return asset('storage/' . $img);
    };
@endphp
<section class="branches-section">
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="section-title">{{ $data['title'] }}</h2>
        @endif
        @if(!empty($data['subtitle']))
            <p class="section-subtitle">{{ $data['subtitle'] }}</p>
        @endif
        <div class="branches-grid">
            @foreach($items as $item)
                @php
                    $img = is_array($item) ? ($item['image'] ?? null) : null;
                    $src = $resolveImg($img);
                @endphp
                <div class="branch-card">
                    @if($src)
                        <div class="branch-image">
                            <img src="{{ $src }}" alt="{{ $item['name'] ?? '' }}">
                        </div>
                    @endif
                    @if(!empty($item['name']))
                        <h3 class="branch-name">{{ $item['name'] }}</h3>
                    @endif
                    @if(!empty($item['address']))
                        <p class="branch-address">{{ $item['address'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
