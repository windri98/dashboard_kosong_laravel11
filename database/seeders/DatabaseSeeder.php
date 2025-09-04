<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Insert default user
        DB::table('users')->insert([
            'id_card' => '00000',
            'jabatan' => 'master',
            'nama' => 'master',
            'username' => 'Rudalpolo',
            'password' => Hash::make('Rudalpolo011'),
            'role_id' => 1,
        ]);

        // Insert default role
        DB::table('roles')->insert([
            'role' => 'SuperAdmin',
            'akses' => 'Administrator role with full access',
        ]);

        // $this->call(PermissionSeeder::class);
    }
}
