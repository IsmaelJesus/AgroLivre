<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Crop;
use App\Models\Farm;
use App\Models\Machinery;
use App\Models\Plot;
use App\Models\Seed;
use App\Models\Supply;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'isOwner' => true,
        ]);

        $user = User::create([
            'name' => 'Ismael',
            'email' => 'ismael.vhs@gmail.com',
            'password' => Hash::make('12345678'),
            'isOwner' => false
        ]);

        $farm = Farm::create([
            'name' => 'Ampessan',
            'location' => 'Cabeceiras',
            'owner_id' => $admin->id,
        ]);

        $plot = Plot::create([
            'name' => 'Lago Azul',
            'area' => '200',
            'farm_id' => $farm->id,
        ]);

        $crop = Crop::create([
            'name' => 'Safra 01/2025',
            'planting_date' => '01/01/2025',
            'harvest_date' => '01/01/2026',
            'farm_id' => $farm->id,
        ]);

        $supply = Supply::create([
            'name' => 'cicuta',
            'type' => 'herbicida',
            'initial_stock_quantity' => '200',
            'measure_unity' => 'Mililitros',
            'value' => '20000',
            'farm_id' => $farm->id,
        ]);

         $seed = Seed::create([
            'name' => 'cicuta',
            'type' => 'herbicida',
            'initial_stock_quantity' => '200',
            'measure_unity' => 'Mililitros',
            'value' => '20000',
            'pms' => '1000',
            'germination' => '95',
            'vigor' => '100',
            'farm_id' => $farm->id,
        ]);

        $machinery = Machinery::create([
            'name' => 'Case 8120',
            'type' => 'colheitadeira',
            'brand' => 'Case',
            'model' => '8120',
            'acquisition_date' => '01/01/2025',
            'hours_use' => '0',
            'acquisition_value' => '600000',
            'useful_life' => '1000',
            'status' => 'true',
            'farm_id' => $farm->id,
        ]);

        $machinery = Machinery::create([
            'name' => 'Plataforma 3020',
            'type' => 'colheitadeira',
            'brand' => 'Case',
            'model' => '3020',
            'acquisition_date' => '01/01/2025',
            'hours_use' => '0',
            'acquisition_value' => '400000',
            'useful_life' => '1000',
            'status' => 'true',
            'farm_id' => $farm->id,
        ]);

        $machinery = Machinery::create([
            'name' => 'Fast Riser 6100',
            'type' => 'plantadeira',
            'brand' => 'Case',
            'model' => '6100',
            'acquisition_date' => '01/01/2025',
            'hours_use' => '0',
            'acquisition_value' => '700000',
            'useful_life' => '10000',
            'status' => 'true',
            'farm_id' => $farm->id,
        ]);

        $machinery = Machinery::create([
            'name' => 'Steiger 500',
            'type' => 'trator',
            'brand' => 'Case',
            'model' => 'Staiger 500',
            'acquisition_date' => '01/01/2025',
            'hours_use' => '0',
            'acquisition_value' => '1900000',
            'useful_life' => '20000',
            'status' => 'true',
            'farm_id' => $farm->id,
        ]);

        $machinery = Machinery::create([
            'name' => 'Adubador Fertiline 8000',
            'type' => 'adubador',
            'brand' => 'Fertiline',
            'model' => 'Fertiline 8000',
            'acquisition_date' => '01/01/2025',
            'hours_use' => '0',
            'acquisition_value' => '200000',
            'useful_life' => '20000',
            'status' => 'true',
            'farm_id' => $farm->id,
        ]);

        $activity1 = Activity::create([
            'name' => 'Plantio 1',
            'type' => 'plantadeira',
            'start_date' => '2025-01-01',
            'finish_date' => '2025-01-10',
            'diesel_value' => 6,
            'observations' => '',
            'crop_id' => $crop->id,
            'plot_id' => $plot->id,
            'supply_id' => null ,
            'seed_id' => $seed->id,
            'farm_id' => $farm->id,
            'user_id' => $user->id,
            'supply_estimated_value' => 100000,
        ]);

        // Adiciona o usuário como membro da fazenda (pivô farm_user)
        $farm->users()->attach($admin->id, ['role' => 'admin']);
        $farm->users()->attach($user->id, ['role' => 'operador']);
    }
}
