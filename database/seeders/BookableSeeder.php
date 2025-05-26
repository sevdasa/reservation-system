<?php

namespace Database\Seeders;

use App\Models\Bookable;
use App\Models\Type;
use App\Models\User;
use App\Models\UserBookable;
use Illuminate\Database\Seeder;

class BookableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user=UserBookable::factory()->create([
            'name' => 'Doctor',
            'email' => 'doctor@example.com'
        ]);
        $user->assignRole('doctor');
        $type = Type::factory()->create();
        
       Bookable::create([
            'name' => $user->name,
            'description' => 'doctor',
            'type_id' => $type->id,
            'user_bookable_id' => $user->id,
        ]);
        
        
    }
}
