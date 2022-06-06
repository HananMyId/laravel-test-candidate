<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('TRUNCATE role_user');
        DB::statement('TRUNCATE users');

        $user = new User();
        $user->name = 'Hanan';
        $user->email = 'hanan@example.com';
        $user->email_verified_at = now();
        $user->password = bcrypt('Admin!23');
        $user->save();

        DB::table('role_user')->insert([
            'role_id' => 1,
            'user_id' => $user->id
        ]);
    }
}
