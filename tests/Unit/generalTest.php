<?php

namespace Tests\Feature;

use App\Models\Ayah;
use App\Models\User;
use App\Models\Word;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class generalTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
{

    // Fetch all users
    $users = User::all();

    // Loop through each user and delete the recently read fields
    foreach ($users as $user) {
        $user->unset('recently_read_surahs');
        $user->unset('recently_read_pages');
        $user->unset('recently_read_juzs');
        $user->save();
    }
}

}
