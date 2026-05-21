<?php

namespace Database\Seeders;

use App\Models\EventType;
use App\Models\Template;
use Illuminate\Database\Seeder;

class EventTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name'        => 'XV Años',
                'slug'        => 'xv-anos',
                'icon'        => '👑',
                'description' => 'Celebra los 15 años más especiales con estilo',
                'templates'   => ['XV Años Elegante', 'XV Años Glamour'],
            ],
            [
                'name'        => 'Boda',
                'slug'        => 'boda',
                'icon'        => '💍',
                'description' => 'Invitaciones para el día más importante de tu vida',
                'templates'   => ['Boda Clásica'],
            ],
            [
                'name'        => 'Cumpleaños',
                'slug'        => 'cumpleanos',
                'icon'        => '🎂',
                'description' => 'Celebra cada año con una invitación única',
                'templates'   => ['Cumpleaños Moderno'],
            ],
            [
                'name'        => 'Corporativo',
                'slug'        => 'corporativo',
                'icon'        => '🏢',
                'description' => 'Eventos empresariales con presencia profesional',
                'templates'   => ['Evento Corporativo'],
            ],
        ];

        foreach ($types as $data) {
            $type = EventType::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'name'        => $data['name'],
                    'icon'        => $data['icon'],
                    'description' => $data['description'],
                    'is_active'   => true,
                ]
            );

            Template::whereIn('name', $data['templates'])
                ->update(['event_type_id' => $type->id]);
        }
    }
}
