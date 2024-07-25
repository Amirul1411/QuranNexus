<?php

namespace Database\Seeders;

use App\Models\Ayah;
use App\Models\Surah;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert initial documents for each collection counter
        DB::collection('counters')->insert([
            ['_id' => 'user_id', 'sequence_value' => User::count()],
            ['_id' => 'surah_id', 'sequence_value' => Surah::count()],
            ['_id' => 'ayah_id', 'sequence_value' => Ayah::count()],
            // Add more collections as needed
        ]);
    }
}
