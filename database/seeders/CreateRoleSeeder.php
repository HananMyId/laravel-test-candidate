<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('TRUNCATE roles');

        $role = new Role();
        $role->id = 1;
        $role->name = 'Administrator';
        $role->save();

        $role = new Role();
        $role->id = 2;
        $role->name = 'Senior HRD';
        $role->save();

        $role = new Role();
        $role->id = 3;
        $role->name = 'HRD';
        $role->save();

    }
}
