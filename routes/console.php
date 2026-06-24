<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Publish blog posts whose scheduled time has passed (runs every minute via cron: * * * * * php artisan schedule:run)
Schedule::command('blog:publish-scheduled')->everyMinute();
