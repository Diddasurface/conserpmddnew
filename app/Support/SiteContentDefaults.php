<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class SiteContentDefaults
{
    public static function content(): array
    {
        $services = [];
        foreach (config('company_services', []) as $slug => $service) {
            $extension = pathinfo($service['image'], PATHINFO_EXTENSION);
            $services[] = array_merge($service, [
                'slug' => $slug,
                'image' => "site-content/services/{$slug}.{$extension}",
                'is_active' => true,
            ]);
        }

        $clients = [];
        foreach (config('clients', []) as $client) {
            $clients[] = [
                'name' => $client['name'],
                'logo' => 'site-content/clients/'.$client['logo'],
                'is_active' => true,
            ];
        }

        return [
            'hero' => [
                'badge' => 'Seguridad y Salud en el Trabajo para empresas',
                'title' => "Protege a tu equipo\ny fortalece tu empresa",
                'description' => 'Implementamos soluciones de Seguridad y Salud en el Trabajo, salud ocupacional, monitoreos, capacitaciones y cumplimiento legal.',
                'highlight' => 'Atención especializada desde Puerto Maldonado para tu organización.',
                'image' => 'site-content/hero/hero.png',
            ],
            'services_section' => [
                'eyebrow' => 'SERVICIOS DESTACADOS',
                'title' => 'Soluciones para cuidar a las personas y a tu operación',
                'description' => 'Estos son algunos de nuestros principales servicios. Cada propuesta se adapta al tamaño, sector y riesgos de tu empresa.',
            ],
            'services' => $services,
            'about' => [
                'eyebrow' => 'CONSERPMDD',
                'title' => 'Gestión preventiva con soluciones aplicables',
                'description' => 'Somos una empresa peruana dedicada a mejorar la competitividad de organizaciones públicas y privadas mediante asesoramiento, auditorías, implementación y mantenimiento de sistemas de gestión.',
                'mission' => 'Brindar servicios de calidad en consultoría, capacitación y asesoría en sistemas de gestión, con la finalidad de mejorar el nivel de competitividad de las empresas.',
                'vision' => 'Ser una de las consultorías más reconocidas a nivel nacional, garantizando el éxito de empresas de todos los rubros económicos.',
                'image' => 'site-content/about/equipo-consultoria.jpg',
            ],
            'clients_section' => [
                'eyebrow' => 'NUESTROS CLIENTES',
                'title' => 'Organizaciones que han confiado en ConserpMDD',
                'description' => 'Empresas, consultoras y operaciones de distintos sectores atendidas por nuestro equipo.',
            ],
            'clients' => $clients,
            'iso_section' => [
                'eyebrow' => 'SISTEMAS DE GESTIÓN',
                'title' => 'Normas ISO como soporte para la mejora continua',
                'description' => 'También brindamos orientación para implementar e integrar sistemas de gestión según las necesidades de cada organización.',
            ],
            'standards' => [
                ['number' => '45001', 'name' => 'Seguridad y salud en el trabajo', 'image' => 'site-content/iso/ISO_45001.png', 'is_active' => true],
                ['number' => '9001', 'name' => 'Gestión de la calidad', 'image' => 'site-content/iso/ISO_9001.png', 'is_active' => true],
                ['number' => '14001', 'name' => 'Gestión ambiental', 'image' => 'site-content/iso/ISO_14001.png', 'is_active' => true],
                ['number' => '22000', 'name' => 'Inocuidad alimentaria', 'image' => 'site-content/iso/ISO_22000.png', 'is_active' => true],
                ['number' => '27001', 'name' => 'Seguridad de la información', 'image' => 'site-content/iso/ISO_27001.png', 'is_active' => true],
                ['number' => '37001', 'name' => 'Gestión antisoborno', 'image' => 'site-content/iso/iso_37001.png', 'is_active' => true],
            ],
        ];
    }

    public static function prepareAssets(): void
    {
        $assets = [
            'images/images/ingeniero_sinfondo.png' => 'site-content/hero/hero.png',
            'images/brochure/equipo-consultoria.jpg' => 'site-content/about/equipo-consultoria.jpg',
        ];

        foreach (config('company_services', []) as $slug => $service) {
            $extension = pathinfo($service['image'], PATHINFO_EXTENSION);
            $assets[$service['image']] = "site-content/services/{$slug}.{$extension}";
        }

        foreach (config('clients', []) as $client) {
            $assets['images/brochure/clients/'.$client['logo']] = 'site-content/clients/'.$client['logo'];
        }

        foreach ([
            'ISO_45001.png', 'ISO_9001.png', 'ISO_14001.png', 'ISO_22000.png',
            'ISO_27001.png', 'iso_37001.png',
        ] as $image) {
            $assets['images/images/iso/'.$image] = 'site-content/iso/'.$image;
        }

        foreach ($assets as $source => $destination) {
            $sourcePath = public_path($source);
            if (is_file($sourcePath) && ! Storage::disk('public')->exists($destination)) {
                Storage::disk('public')->put($destination, file_get_contents($sourcePath));
            }
        }
    }
}
