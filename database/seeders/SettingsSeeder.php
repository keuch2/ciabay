<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['group' => 'general', 'key' => 'site_name', 'value' => 'Ciabay', 'type' => 'text'],
            ['group' => 'general', 'key' => 'site_tagline', 'value' => 'Agricultura en buenas manos', 'type' => 'text'],
            ['group' => 'general', 'key' => 'site_description', 'value' => 'Más de 31 años distribuyendo maquinaria agrícola Case IH, implementos, insumos y agricultura de precisión en Paraguay.', 'type' => 'textarea'],
            ['group' => 'general', 'key' => 'site_logo', 'value' => '/assets/images/logo.jpg', 'type' => 'image'],
            ['group' => 'general', 'key' => 'site_logo_white', 'value' => '/assets/images/logo-white.png', 'type' => 'image'],
            ['group' => 'general', 'key' => 'site_favicon', 'value' => '/assets/images/favicon.ico', 'type' => 'image'],

            // Contacto
            ['group' => 'contact', 'key' => 'contact_phone', 'value' => '(021) 525 900', 'type' => 'text'],
            ['group' => 'contact', 'key' => 'contact_email', 'value' => 'info@ciabay.com.py', 'type' => 'text'],
            ['group' => 'contact', 'key' => 'contact_address', 'value' => 'Ruta Mcal. Estigarribia Km 16, Capiatá, Paraguay', 'type' => 'text'],
            ['group' => 'contact', 'key' => 'contact_hours', 'value' => 'Lunes a Viernes: 07:00 - 17:00 | Sábados: 07:00 - 12:00', 'type' => 'text'],

            // WhatsApp
            ['group' => 'whatsapp', 'key' => 'whatsapp_number', 'value' => '595983730082', 'type' => 'text'],
            ['group' => 'whatsapp', 'key' => 'whatsapp_message_template', 'value' => 'Hola, soy {nombre} ({telefono}). Me interesa el producto: {producto}. {mensaje}', 'type' => 'textarea'],

            // Redes sociales
            ['group' => 'social', 'key' => 'social_facebook', 'value' => 'https://www.facebook.com/ciabaysa', 'type' => 'text'],
            ['group' => 'social', 'key' => 'social_instagram', 'value' => 'https://www.instagram.com/ciabaysa', 'type' => 'text'],
            ['group' => 'social', 'key' => 'social_linkedin', 'value' => 'https://www.linkedin.com/company/ciabay', 'type' => 'text'],
            ['group' => 'social', 'key' => 'social_youtube', 'value' => 'https://www.youtube.com/@ciabaysa', 'type' => 'text'],
            ['group' => 'social', 'key' => 'social_tiktok', 'value' => 'https://www.tiktok.com/@ciabaysa', 'type' => 'text'],

            // Top bar
            ['group' => 'topbar', 'key' => 'topbar_text', 'value' => 'Envíos a todo el Paraguay', 'type' => 'text'],
            ['group' => 'topbar', 'key' => 'topbar_link_text', 'value' => 'Pedí tu delivery →', 'type' => 'text'],
            ['group' => 'topbar', 'key' => 'topbar_link_url', 'value' => 'https://wa.me/595983730082', 'type' => 'text'],

            // Footer
            ['group' => 'footer', 'key' => 'footer_description', 'value' => 'Más de 31 años siendo el aliado estratégico del productor paraguayo. Maquinaria, implementos, insumos y tecnología para el campo.', 'type' => 'textarea'],
            ['group' => 'footer', 'key' => 'footer_copyright', 'value' => '© {year} Ciabay S.A. Todos los derechos reservados.', 'type' => 'text'],

            // SEO
            ['group' => 'seo', 'key' => 'google_analytics_id', 'value' => '', 'type' => 'text'],
            ['group' => 'seo', 'key' => 'google_tag_manager_id', 'value' => '', 'type' => 'text'],
            ['group' => 'seo', 'key' => 'meta_pixel_id', 'value' => '', 'type' => 'text'],

            // Maps
            ['group' => 'maps', 'key' => 'google_maps_embed_url', 'value' => 'https://www.google.com/maps/d/u/0/embed?mid=16DQH3k9kR3NM8_F5CVMXW1lVK2bM3Ng&ehbc=2E312F&noprof=1', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
