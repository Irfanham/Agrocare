<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        DB::table('users')->insert([
            [
            'name'=>'Admin',
            'email'=> "admin@gmail.com",
            'role_id'=>1,
            'nohp'=>'085641235',
            'alamat'=>'suruh',
            'username'=>'adminaja',
            'password'=>Hash::make("admin"),
        
            ],
            [
            'name'=>'Expert',
            'email'=> "expert@gmail.com",
            'role_id'=>2,
            'nohp'=>'08564123456',
            'alamat'=>'salatiga',
            'username'=>'tenahnih',
            'password'=>Hash::make("expert"),
            ],
            [
            'name'=>'Farmer',
            'email'=> "farmer@gmail.com",
            'role_id'=>3,
            'nohp'=>'0856781234',
            'alamat'=>'jatirejo',
            'username'=>'petaniemas',
            'password'=>Hash::make("farmer"),
            ]
        ]
    );
    }
}
