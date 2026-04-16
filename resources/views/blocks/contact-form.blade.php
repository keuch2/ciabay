<section class="contact-section" style="padding: 4rem 0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem;">
            <div>
                @if(!empty($data['title']))
                    <h2 class="section-title">{{ $data['title'] }}</h2>
                @endif
                @if(!empty($data['text']))
                    <div class="intro-text">{!! $data['text'] !!}</div>
                @endif

                @if(!empty($data['show_info']))
                    <div style="margin-top: 2rem; space-y: 1rem;">
                        @php $phone = \App\Models\Setting::get('contact_phone'); @endphp
                        @if($phone)
                            <p><strong>Teléfono:</strong> <a href="tel:{{ $phone }}">{{ $phone }}</a></p>
                        @endif
                        @php $email = \App\Models\Setting::get('contact_email'); @endphp
                        @if($email)
                            <p><strong>Email:</strong> <a href="mailto:{{ $email }}">{{ $email }}</a></p>
                        @endif
                        @php $address = \App\Models\Setting::get('contact_address'); @endphp
                        @if($address)
                            <p><strong>Dirección:</strong> {{ $address }}</p>
                        @endif
                    </div>
                @endif
            </div>

            <div>
                <form action="{{ route('contact.submit') }}" method="POST" class="contact-form">
                    @csrf
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label for="name" class="form-label">Nombre y Apellido *</label>
                        <input type="text" id="name" name="name" class="form-input" required value="{{ old('name') }}">
                        @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" id="email" name="email" class="form-input" required value="{{ old('email') }}">
                        @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label for="phone" class="form-label">Teléfono</label>
                        <input type="text" id="phone" name="phone" class="form-input" value="{{ old('phone') }}">
                    </div>
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label for="subject" class="form-label">Asunto</label>
                        <input type="text" id="subject" name="subject" class="form-input" value="{{ old('subject') }}">
                    </div>
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label for="message" class="form-label">Mensaje *</label>
                        <textarea id="message" name="message" rows="5" class="form-input" required>{{ old('message') }}</textarea>
                        @error('message') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="honeypot-field" style="display:none;">
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>
                    <button type="submit" class="form-submit-btn btn-primary">Enviar Mensaje</button>
                </form>

                @if(session('success'))
                    <div style="margin-top: 1rem; padding: 1rem; background: #d4edda; color: #155724; border-radius: 8px;">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
