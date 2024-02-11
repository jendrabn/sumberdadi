<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'J.Coffee',
            'password' => app('hash')->make('123'),
            'email' => 'admin@jcoffee.test'
        ])->assignRole(['admin', 'user']);

        factory(User::class, 49)->create()->each(function ($u) {
            $u->assignRole('user');
        });

        User::create([
            'first_name' => 'Example',
            'last_name' => 'User',
            'password' => app('hash')->make('123'),
            'email' => 'user@jcoffee.test'
        ])->assignRole('user');
    }
}
