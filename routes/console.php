<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

Schedule::command('app:cleanup-recently-read')->everyThirtyMinutes();
Schedule::command('app:reset-recitation-streak')->daily();
Schedule::command('app:update-password-reset-tokens')->everySecond();
