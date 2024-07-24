<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('counters', function ($collection) {
            // No schema definition needed for MongoDB
        });

        // Insert initial documents for each collection counter
        DB::collection('counters')->insert([
            ['_id' => 'user_id', 'sequence_value' => 0],
            ['_id' => 'surah_id', 'sequence_value' => 0],
            ['_id' => 'ayah_id', 'sequence_value' => 0],
            // Add more collections as needed
        ]);
    }



    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('counters');
    }
};
