<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'Super Admin',
            'guard_name' => 'web',
            'created_at' => Carbon::now()->toDateTimeString(),
            'created_by' => null,
            'deleted_by' => null,
            'deleted_at' => Carbon::now()->toDateTimeString(),
        ]);
    }
}
