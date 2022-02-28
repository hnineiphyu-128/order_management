<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admin = User::create([
        	'name'		=> 'Super Admin',
        	'email'		=>	'admin@gmail.com',
        	'phone'		=>	'09406405232',
        	'password'	=>	Hash::make('12345')
        ]);
        $admin->assignRole('admin');

        $sale = User::create([
        	'name'		=> 'Sale Man',
        	'email'		=>	'saleman@gmail.com',
        	'phone'		=>	'09797809783',
        	'password'	=>	Hash::make('12345')
        ]);
        $sale->assignRole('sale');
    }
}
