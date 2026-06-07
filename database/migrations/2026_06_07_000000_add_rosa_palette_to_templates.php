<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $rosaPalettes = [
            'templates.xv-rustico' => [
                'name'    => 'Rosa',
                'preview' => ['#F6E7E4', '#C77B83', '#EDD8D4', '#7A3B45'],
                'vars'    => [
                    'cream'      => '#F6E7E4',
                    'cream-2'    => '#EDD8D4',
                    'paper'      => '#FAF0EE',
                    'terra'      => '#C77B83',
                    'terra-deep' => '#7A3B45',
                    'terra-soft' => '#DDA8B0',
                    'olive'      => '#8B6B6E',
                    'ink'        => '#3A1820',
                    'ink-soft'   => '#7A5560',
                ],
            ],
            'templates.xv-glamour' => [
                'name'    => 'Rosa',
                'preview' => ['#F6E7E4', '#C77B83', '#EDD8D4', '#7A3B45'],
                'vars'    => [
                    'gold'        => '#C77B83',
                    'gold-light'  => '#DDA8B0',
                    'gold-dark'   => '#7A3B45',
                    'cream'       => '#F6E7E4',
                    'dark'        => '#3A1820',
                    'purple'      => '#9A4A55',
                    'purple-mid'  => '#B86B75',
                ],
            ],
        ];

        foreach ($rosaPalettes as $bladeFile => $palette) {
            $template = DB::table('templates')->where('blade_file', $bladeFile)->first();
            if (!$template) continue;

            $palettes   = json_decode($template->color_palettes, true) ?? [];
            $palettes[] = $palette;

            DB::table('templates')
                ->where('blade_file', $bladeFile)
                ->update(['color_palettes' => json_encode($palettes)]);
        }
    }

    public function down(): void
    {
        foreach (['templates.xv-rustico', 'templates.xv-glamour'] as $bladeFile) {
            $template = DB::table('templates')->where('blade_file', $bladeFile)->first();
            if (!$template) continue;

            $palettes = json_decode($template->color_palettes, true) ?? [];
            $palettes = array_values(array_filter($palettes, fn ($p) => $p['name'] !== 'Rosa'));

            DB::table('templates')
                ->where('blade_file', $bladeFile)
                ->update(['color_palettes' => json_encode($palettes)]);
        }
    }
};
