<?php

namespace Database\Seeders;

use App\Models\Bookable;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookableSeeder extends Seeder
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
        
        $type = Type::factory()->create();
        
        $bookable = Bookable::create([
            'name' => $user->name,
            'description' => 'doctor',
            'type_id' => $type->id,
            'user_id' => $user->id,
        ]);
        
        // به مدل bookable نقش doctor با گارد bookable بده
        $bookable->assignRole('doctor');
        
    }
}
