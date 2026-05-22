<?php

use App\Console\Commands\BackfillUserRoles;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('users:backfill-roles {--dry-run} {--force}', function () {
    $command = app(BackfillUserRoles::class);
    $command->setLaravel($this->laravel);
    $command->setOutput($this->output);
    $command->setInput($this->input);

    return $command->handleBackfill(
        dryRun: $this->option('dry-run'),
        force: $this->option('force')
    );
})->purpose('Backfill missing user roles from legacy is_admin values');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
