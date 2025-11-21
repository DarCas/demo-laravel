<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->withSchedule(function (Schedule $schedule): void {
        // Vedi https://crontab.guru/ per maggiori informazioni sui formati di cron
        
        $schedule->command('view:cache')
            ->cron('0 0 1,15 * *');

        $schedule->command('view:clear')
            ->cron('0 0 1,15 * *');

        $schedule->command('app:backup-products')
            ->everyFiveMinutes();
    })
    ->create();
