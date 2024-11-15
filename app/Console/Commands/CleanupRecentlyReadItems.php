<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CleanupRecentlyReadItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-recently-read';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old recently read items from user records';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->cleanOldRecentlyReadItems('surah');
            $user->cleanOldRecentlyReadItems('page');
            $user->cleanOldRecentlyReadItems('juz');
        }

        $this->info('Old recently read items cleaned up.');
    }
}
