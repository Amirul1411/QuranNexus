<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\UTCDateTime;

class UpdatePasswordResetTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-password-reset-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $collection = DB::connection('mongodb')->collection('password_reset_tokens');

        // Iterate through records to convert created_at to a Date
        $documents = $collection->where('created_at', ['$type' => 'object'])->get();

        foreach ($documents as $doc) {
            $collection->where('_id', $doc['_id'])->update([
                '$set' => [
                    'created_at' => new Date("<YYYY-mm-ddTHH:MM:ssZ>"),
                ],
            ]);
        }

        $this->info('Updated ' . count($documents) . ' document(s).');
        return 0;
    }
}
