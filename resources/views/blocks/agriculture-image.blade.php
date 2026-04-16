<section class="agriculture-section">
    <div class="agriculture-background">
        <img src="{{ asset($data['background_image'] ?? 'assets/images/maquina.jpg') }}" alt="{{ $data['background_alt'] ?? 'Agricultor' }}" class="agriculture-bg-img">
    </div>
    <div class="agriculture-overlay-image">
        <img src="{{ asset($data['overlay_image'] ?? 'assets/images/agricultura.png') }}" alt="{{ $data['overlay_alt'] ?? 'Agricultura en buenas manos' }}" class="agriculture-overlay-img">
    </div>
</section>
