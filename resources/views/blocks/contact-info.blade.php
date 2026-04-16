@php
    $title = $data['title'] ?? 'Información de Contacto';
    $formTitle = $data['form_title'] ?? 'Envíanos un Mensaje';
    $address = $data['address'] ?: \App\Models\Setting::get('contact_address', '');
    $phone = $data['phone'] ?: \App\Models\Setting::get('contact_phone', '');
    $email = $data['email'] ?: \App\Models\Setting::get('contact_email', '');
    $hours = $data['hours'] ?? "Lunes a Viernes: 7:00 - 17:00\nSábados: 7:00 - 12:00";
    $socials = [
        ['key' => 'social_facebook', 'label' => 'Facebook', 'icon' => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z'],
        ['key' => 'social_instagram', 'label' => 'Instagram', 'icon' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z'],
        ['key' => 'social_youtube', 'label' => 'YouTube', 'icon' => 'M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z'],
        ['key' => 'social_tiktok', 'label' => 'TikTok', 'icon' => 'M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z'],
    ];
@endphp
<section class="contact-info-section">
    <div class="container">
        <div class="contact-info-grid">
            <div class="contact-details">
                <h2 class="contact-section-title">{{ $title }}</h2>
                @if($address)
                    <div class="contact-item">
                        <h3 class="contact-item-title">Dirección</h3>
                        <p class="contact-item-text">{{ $address }}</p>
                    </div>
                @endif
                @if($phone)
                    <div class="contact-item">
                        <h3 class="contact-item-title">Teléfonos</h3>
                        <p class="contact-item-text">
                            <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="contact-link">{{ $phone }}</a>
                        </p>
                    </div>
                @endif
                @if($email)
                    <div class="contact-item">
                        <h3 class="contact-item-title">Email</h3>
                        <p class="contact-item-text">
                            <a href="mailto:{{ $email }}" class="contact-link">{{ $email }}</a>
                        </p>
                    </div>
                @endif
                @if($hours)
                    <div class="contact-item">
                        <h3 class="contact-item-title">Horario de Atención</h3>
                        <p class="contact-item-text">{!! nl2br(e($hours)) !!}</p>
                    </div>
                @endif
                <div class="contact-item">
                    <h3 class="contact-item-title">Redes Sociales</h3>
                    <div class="contact-social-icons">
                        @foreach($socials as $s)
                            @php $url = \App\Models\Setting::get($s['key']); @endphp
                            @if($url)
                                <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="contact-social-icon" aria-label="{{ $s['label'] }}">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="{{ $s['icon'] }}"/></svg>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="contact-form-wrapper">
                <h2 class="contact-section-title">{{ $formTitle }}</h2>
                @if(session('success'))
                    <div class="form-message" style="background:#d4edda;border:1px solid #c3e6cb;color:#155724;padding:1rem;border-radius:8px;margin-bottom:1.5rem;">
                        {{ session('success') }}
                    </div>
                @endif
                <form class="contact-form" method="POST" action="{{ route('contact.submit') }}">
                    @csrf
                    <div class="form-group" style="position: absolute; left: -9999px;">
                        <label for="website">Website</label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-label">Nombre Completo *</label>
                        <input type="text" id="name" name="name" class="form-input" required value="{{ old('name') }}">
                        @error('name') <span style="color:#dc3545;font-size:0.85rem;">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" id="email" name="email" class="form-input" required value="{{ old('email') }}">
                        @error('email') <span style="color:#dc3545;font-size:0.85rem;">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone" class="form-label">Teléfono *</label>
                        <input type="tel" id="phone" name="phone" class="form-input" required value="{{ old('phone') }}">
                    </div>
                    <div class="form-group">
                        <label for="subject" class="form-label">Asunto *</label>
                        <input type="text" id="subject" name="subject" class="form-input" required value="{{ old('subject') }}">
                    </div>
                    <div class="form-group">
                        <label for="message" class="form-label">Mensaje *</label>
                        <textarea id="message" name="message" class="form-textarea" rows="5" required>{{ old('message') }}</textarea>
                        @error('message') <span style="color:#dc3545;font-size:0.85rem;">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="form-submit-btn">Enviar Mensaje</button>
                </form>
            </div>
        </div>
    </div>
</section>
