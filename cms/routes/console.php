<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('statecorps:publish-scheduled')->everyMinute();

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
