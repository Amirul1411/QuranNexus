<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ResetRecitationStreak extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-recitation-streak';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset recitation streak to 0 if the user missed one day from recitation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->resetRecitationStreak();
        }

        $this->info('Recitation streaks have been reset.');
    }
}
