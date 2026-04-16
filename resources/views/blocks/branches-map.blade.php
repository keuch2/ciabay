<section class="branches-section">
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="section-title">{{ $data['title'] }}</h2>
        @endif
        @if(!empty($data['subtitle']))
            <p class="section-subtitle">{{ $data['subtitle'] }}</p>
        @endif

        @php
            $branches = \App\Models\Branch::active()->orderBy('sort_order')->get();
        @endphp

        <div class="branches-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem; margin-top: 2rem;">
            @foreach($branches as $branch)
                <div class="branch-card" style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.08);">
                    @php
                        $img = $branch->image;
                        $src = null;
                        if ($img) {
                            if (preg_match('#^(https?:)?//#', $img)) {
                                $src = $img;
                            } elseif (str_starts_with($img, 'assets/') || str_starts_with($img, 'storage/')) {
                                $src = asset($img);
                            } else {
                                $src = asset('storage/' . $img);
                            }
                        }
                    @endphp
                    @if($src)
                        <img src="{{ $src }}" alt="{{ $branch->name }}" style="width: 100%; height: 180px; object-fit: cover;">
                    @endif
                    <div style="padding: 1.5rem;">
                        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $branch->name }}</h3>
                        @if($branch->address)
                            <p style="font-size: 0.9rem; color: #666; margin-bottom: 0.25rem;">{{ $branch->address }}</p>
                        @endif
                        @if($branch->city)
                            <p style="font-size: 0.9rem; color: #666; margin-bottom: 0.5rem;">{{ $branch->city }}{{ $branch->department ? ', ' . $branch->department : '' }}</p>
                        @endif
                        @if($branch->phone)
                            <p style="font-size: 0.9rem;"><a href="tel:{{ $branch->phone }}" style="color: var(--color-primary);">{{ $branch->phone }}</a></p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @php
            $mapsApiKey = \App\Models\Setting::get('google_maps_api_key');
        @endphp
        @if($mapsApiKey && $branches->count())
            @php
                $markers = $branches->map(function ($b) {
                    return [
                        'name' => $b->name,
                        'lat' => $b->latitude,
                        'lng' => $b->longitude,
                        'address' => $b->address,
                    ];
                });
            @endphp
            <div id="branches-map" style="width: 100%; height: 450px; margin-top: 2rem; border-radius: 12px; overflow: hidden;"></div>
            @push('scripts')
            <script>
            function initMap() {
                const map = new google.maps.Map(document.getElementById('branches-map'), {
                    zoom: 6,
                    center: { lat: -23.5, lng: -58.5 },
                });
                const branches = {!! $markers->toJson() !!};
                branches.forEach(b => {
                    if (b.lat && b.lng) {
                        new google.maps.Marker({
                            position: { lat: parseFloat(b.lat), lng: parseFloat(b.lng) },
                            map, title: b.name,
                        });
                    }
                });
            }
            </script>
            <script async src="https://maps.googleapis.com/maps/api/js?key={{ $mapsApiKey }}&callback=initMap"></script>
            @endpush
        @endif
    </div>
</section>
