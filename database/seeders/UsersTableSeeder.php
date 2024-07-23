<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
        $users = [
            [
                'name' => 'MentorsAdmin',
                'email' => 'mentorspireitservices@gmail.com',
                'email_verified_at' => null,
                'password' => bcrypt('mentorSecrets'), // password
                'remember_token' => null,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
