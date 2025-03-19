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
        
        // Comment out the seeder class that you don't want to run

        $this->call([
            CounterSeeder::class,
            // UserSeeder::class,
            // InquirySeeder::class,
            // JuzSeeder::class,
            // PageSeeder::class,
            // SurahSeeder::class,
            // SurahInfoSeeder::class,
            // AyahSeeder::class,
            // WordSeeder::class,
            // TafseerInfoSeeder::class,
            // TafseerSeeder::class,
            // TranslationInfoSeeder::class,
            // TranslationSeeder::class,
            // AudioRecitationInfoSeeder::class,
            // AudioRecitationSeeder::class,
            // AchievementSeeder::class,
            // ChaptersInitialsSeeder::class,
            // CharacterFrequencySeeder::class,
            // LongestTokenSeeder::class,
            // DiacriticFrequencySeeder::class,
            WordStatisticsSeeder::class,
        ]);
    }
}
