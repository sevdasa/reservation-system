<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserBookable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserBookableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::where('email', 'sevdasazdar@gmail.com')->exists()) {
            $user = User::where('email', 'sevdasazdar@gmail.com')->first();
        } else {
            $user = User::factory()->create();
        }
        
        
        $bookable = UserBookable::create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
        ]);
        
        $bookable->assignRole('doctor');
        
    }
}
