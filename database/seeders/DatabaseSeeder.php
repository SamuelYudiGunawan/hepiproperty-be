<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $role = [
            [
                'name' => 'Owner',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Admin',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Customer',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Agent',
                'guard_name' => 'web',
            ],
            [
                'name' => 'PR',
                'guard_name' => 'web',
            ]

        ];
        for ($i=0; $i < count($role); $i++) { 
            Role::create($role[$i]);
        }
        $user =  User::create(
                [
                    'name'     => 'owner',
                    'email'    => 'owner@admin.com',
                    'password' => Hash::make('owner1234'),
                ]
            );
        $user = User::find(1);
        $user -> assignRole('Owner');
        
    }
}
