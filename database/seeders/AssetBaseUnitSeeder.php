<?php

namespace Database\Seeders;

use App\Models\AssetBaseUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetBaseUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insert = new AssetBaseUnit;
        $insert1 = clone $insert;
        $insert2 = clone $insert;

        $insert2->name = 'Piece';
        $insert->name = 'Meter';
        $insert1->name = 'Kilogram';
        
        $insert->save();
        $insert1->save();
        $insert2->save();
    }
}
