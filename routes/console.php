<?php

use App\Jobs\DeleteExpiredOrders;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');



Schedule::job(new DeleteExpiredOrders)->dailyAt('03:00');

// php artisan schedule:list
// php artisan schedule:work
