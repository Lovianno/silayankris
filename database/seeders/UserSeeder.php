<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
  public function run(): void
  {
    $users = [
      [
        'name' => 'Admin User',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
      ],
      [
        'name' => 'Regular User',
        'email' => 'user@gmail.com',
        'password' => bcrypt('password'),
        'role' => 'user',
      ],
    ];

    foreach ($users as $user) {
      User::create($user);
    }
  }
}
