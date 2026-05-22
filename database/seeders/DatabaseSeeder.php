<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Template;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Usuario de prueba ────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'admin@invitaciones.test'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('password'),
                'phone'    => '+528112345678',
                'plan'     => 'pro',
            ]
        );

        // ─── Plantillas iniciales ─────────────────────────────────
        $templates = [
            [
                'name'          => 'Boda Clásica',
                'thumbnail_url' => '/img/templates/boda-clasica.svg',
                'blade_file'    => 'templates.boda-clasica',
                'default_colors' => [
                    'primary'    => '#c9a96e',
                    'secondary'  => '#f5efe6',
                    'text'       => '#3d2b1f',
                    'background' => '#fff9f0',
                ],
                'is_active' => true,
            ],
            [
                'name'          => 'XV Años Elegante',
                'thumbnail_url' => '/img/templates/xv-elegante.svg',
                'blade_file'    => 'templates.xv-elegante',
                'default_colors' => [
                    'primary'    => '#d4a0c0',
                    'secondary'  => '#fdf0f7',
                    'text'       => '#4a1942',
                    'background' => '#fff5fc',
                ],
                'is_active' => true,
            ],
            [
                'name'          => 'XV Años Glamour',
                'thumbnail_url' => '/img/templates/xv-glamour.svg',
                'blade_file'    => 'templates.xv-glamour',
                'default_colors' => [
                    'primary'    => '#c8a96e',
                    'secondary'  => '#C875DC',
                    'text'       => '#3D0F55',
                    'background' => '#FDF6FF',
                ],
                'is_active' => true,
            ],
            [
                'name'          => 'XV Años Rústico',
                'thumbnail_url' => '/img/templates/xv-rustico.svg',
                'blade_file'    => 'templates.xv-rustico',
                'default_colors' => [
                    'primary'    => '#B25A36',
                    'secondary'  => '#F4E8D5',
                    'text'       => '#3A2718',
                    'background' => '#FAF3E8',
                ],
                'is_active' => true,
            ],
            [
                'name'          => 'Cumpleaños Moderno',
                'thumbnail_url' => '/img/templates/cumple-moderno.svg',
                'blade_file'    => 'templates.cumple-moderno',
                'default_colors' => [
                    'primary'    => '#6c63ff',
                    'secondary'  => '#f0eeff',
                    'text'       => '#1a1a2e',
                    'background' => '#fafafa',
                ],
                'is_active' => true,
            ],
            [
                'name'          => 'Evento Corporativo',
                'thumbnail_url' => '/img/templates/corporativo.svg',
                'blade_file'    => 'templates.corporativo',
                'default_colors' => [
                    'primary'    => '#1a365d',
                    'secondary'  => '#ebf4ff',
                    'text'       => '#1a202c',
                    'background' => '#f7fafc',
                ],
                'is_active' => true,
            ],
        ];

        foreach ($templates as $template) {
            Template::firstOrCreate(
                ['name' => $template['name']],
                $template
            );
        }

        $this->call(EventTypeSeeder::class);
    }
}
