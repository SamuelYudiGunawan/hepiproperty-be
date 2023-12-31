<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\KotaSeeder;
use Spatie\Permission\Models\Role;
use Database\Seeders\ProvinsiSeeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\KecamatanSeeder;
use Database\Seeders\PropertyTypeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $owner = Role::create([
            'name' => 'owner',
            'guard_name' => 'web',
        ]);
        $admin = Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);
        $customer = Role::create([
            'name' => 'customer',
            'guard_name' => 'web',
        ]);
        $agent = Role::create([
            'name' => 'agent',
            'guard_name' => 'web',
        ]);
        $pr = Role::create([
            'name' => 'pr',
            'guard_name' => 'web',
        ]);
        $user =  User::create(
                [
                    'name'     => 'owner',
                    'email'    => 'owner@admin.com',
                    'password' => Hash::make('owner1234'),
                ]
            );
        $user = User::find(1);
        $user -> assignRole('owner');
        
        $this->call(ProvinsiSeeder::class);
        $this->call(KotaSeeder::class);
        $this->call(KecamatanSeeder::class);
    }
}
