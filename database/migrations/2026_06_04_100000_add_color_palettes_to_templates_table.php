<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->json('color_palettes')->nullable()->after('default_colors');
        });

        $palettes = [
            'templates.xv-rustico' => [
                ['name' => 'Rústico',  'preview' => ['#F4E8D5','#B25A36','#EADBC1','#3A2718'],
                 'vars' => ['cream'=>'#F4E8D5','cream-2'=>'#EADBC1','paper'=>'#F9F1E1','terra'=>'#B25A36','terra-deep'=>'#6F2E1B','terra-soft'=>'#D89274','olive'=>'#6E7A55','ink'=>'#3A2718','ink-soft'=>'#7A6451']],
                ['name' => 'Olivo',    'preview' => ['#EEE9DC','#5C6B43','#D8D2C0','#2A2D1A'],
                 'vars' => ['cream'=>'#EEE9DC','cream-2'=>'#D8D2C0','paper'=>'#F5F0E4','terra'=>'#5C6B43','terra-deep'=>'#3A4529','terra-soft'=>'#8B9E6A','olive'=>'#8B6E3C','ink'=>'#2A2D1A','ink-soft'=>'#5C6040']],
                ['name' => 'Vino',     'preview' => ['#F5ECE8','#7C2D3E','#E8D8D0','#2A1018'],
                 'vars' => ['cream'=>'#F5ECE8','cream-2'=>'#E8D8D0','paper'=>'#FBF5F2','terra'=>'#7C2D3E','terra-deep'=>'#4A1525','terra-soft'=>'#B06878','olive'=>'#6E4040','ink'=>'#2A1018','ink-soft'=>'#6E4855']],
                ['name' => 'Pizarra',  'preview' => ['#EBE8E2','#4A6580','#D8D3C8','#1C2B3A'],
                 'vars' => ['cream'=>'#EBE8E2','cream-2'=>'#D8D3C8','paper'=>'#F5F3EE','terra'=>'#4A6580','terra-deep'=>'#2A3D50','terra-soft'=>'#7A9AB5','olive'=>'#6E7A55','ink'=>'#1C2B3A','ink-soft'=>'#5A6A7A']],
                ['name' => 'Ébano',    'preview' => ['#F2E8D5','#2A2018','#E0D0B8','#1A1208'],
                 'vars' => ['cream'=>'#F2E8D5','cream-2'=>'#E0D0B8','paper'=>'#FAF3E4','terra'=>'#2A2018','terra-deep'=>'#150F0A','terra-soft'=>'#5A4838','olive'=>'#8B7050','ink'=>'#1A1208','ink-soft'=>'#5A4838']],
            ],
            'templates.xv-glamour' => [
                ['name' => 'Glamour',    'preview' => ['#FDF6FF','#c8a96e','#F0DCFF','#3D0F55'],
                 'vars' => ['gold'=>'#c8a96e','gold-light'=>'#e8d5a3','gold-dark'=>'#a8843e','cream'=>'#FDF6FF','dark'=>'#3D0F55','purple'=>'#7B3AAF','purple-mid'=>'#A85BC8']],
                ['name' => 'Oro Rosa',   'preview' => ['#FFF5F7','#C2688A','#FFE0E8','#4A1830'],
                 'vars' => ['gold'=>'#C2688A','gold-light'=>'#E098B0','gold-dark'=>'#803050','cream'=>'#FFF5F7','dark'=>'#4A1830','purple'=>'#8A3060','purple-mid'=>'#C06080']],
                ['name' => 'Esmeralda',  'preview' => ['#F3FFF8','#2E7D52','#D0F0E0','#0D2B1A'],
                 'vars' => ['gold'=>'#2E7D52','gold-light'=>'#60A878','gold-dark'=>'#1A4A30','cream'=>'#F3FFF8','dark'=>'#0D2B1A','purple'=>'#2A6050','purple-mid'=>'#4A9070']],
                ['name' => 'Zafiro',     'preview' => ['#F5F8FF','#3454A0','#D4E0FF','#0D1B4A'],
                 'vars' => ['gold'=>'#3454A0','gold-light'=>'#6888C8','gold-dark'=>'#1A2D6A','cream'=>'#F5F8FF','dark'=>'#0D1B4A','purple'=>'#3060A0','purple-mid'=>'#5080C0']],
            ],
        ];

        foreach ($palettes as $bladeFile => $data) {
            DB::table('templates')
                ->where('blade_file', $bladeFile)
                ->update(['color_palettes' => json_encode($data)]);
        }
    }

    public function down(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropColumn('color_palettes');
        });
    }
};
