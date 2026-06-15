<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PDOUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the single PDO officer user
        User::create([
            'name' => 'PDO Officer',
            'email' => 'pdo@example.com',
            'password' => Hash::make('password'), // default password, user can change later
        ]);
    }
}
?>
