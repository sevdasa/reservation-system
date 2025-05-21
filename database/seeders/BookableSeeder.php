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
        $user = User::factory()->create();
        $user->assignRole('doctor');
        $type = Type::factory()->create();
        Bookable::create([
            'name' => 'test',
            'description' => 'doctor',
            'type_id' => $type->id,
            'user_id' => $user->id,
        ]);
    }
}
