<?php

namespace Database\Seeders;

// use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            CounterSeeder::class,
            UserSeeder::class,
            InquirySeeder::class,
            // JuzSeeder::class,
            // PageSeeder::class,
            // SurahSeeder::class,
            // SurahInfoSeeder::class,
            // AyahSeeder::class,
            WordSeeder::class,
            // TafseerInfoSeeder::class,
            // TafseerSeeder::class,
            // TranslationInfoSeeder::class,
            // TranslationSeeder::class,
            // AudioRecitationInfoSeeder::class,
            // AudioRecitationSeeder::class,
        ]);
    }
}
