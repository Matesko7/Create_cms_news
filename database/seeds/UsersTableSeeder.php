<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.sk',
            'password' => Hash::make('*admin*'),
            'remember_token' => str_random(10),
        ]);

        User::create([
            'name' => 'redaktor',
            'email' => 'redaktor@redaktor.sk',
            'password' => Hash::make('*redaktor*'),
            'remember_token' => str_random(10),
        ]);

        User::create([
            'name' => 'navstevnik',
            'email' => 'navstevnik@redaktor.sk',
            'password' => Hash::make('*navstevnik*'),
            'remember_token' => str_random(10),
        ]);
    }
}
