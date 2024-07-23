<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AnotherUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => '1stAdmin',
                'email'=>'1st_admin@email.com',
                'email_verified_at' => null,
                'password'=> bcrypt('1stSecrets'),
                'remember_token' => null,
            ],
            [
               'name' => '2ndAdmin',
               'email'=>'2nd_admin@email.com',
               'email_verified_at' => null,
               'password'=> bcrypt('2ndSecrets'),
               'remember_token' => null,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
