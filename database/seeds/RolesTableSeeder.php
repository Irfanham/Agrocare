<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('roles')->insert([
            [
            'role_name'=>'Admin',
            'role_slug'=> "admin",
        
            ],
            [
            'role_name'=>'Expert',
            'role_slug'=> "farmer",
            ],
            [
            'role_name'=>'Farmer',
            'role_slug'=> "farmer",
            ]
        ]
    );
    }
}
