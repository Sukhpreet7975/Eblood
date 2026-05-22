<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class BackfillUserRoles extends Command
{
    protected $signature = 'users:backfill-roles {--dry-run : Show pending changes without modifying records} {--force : Run without confirmation}';

    protected $description = 'Backfill missing user roles from legacy MongoDB is_admin values.';

    public function handle(): int
    {
        return $this->handleBackfill(
            dryRun: $this->option('dry-run'),
            force: $this->option('force')
        );
    }

    public function handleBackfill(bool $dryRun = false, bool $force = false): int
    {
        $legacyUsers = User::where(function ($query) {
            $query->whereNull('role')->orWhere('role', '');
        })->get();

        if ($legacyUsers->isEmpty()) {
            $this->info('No users require role backfill.');
            return Command::SUCCESS;
        }

        $rows = [];
        $adminCount = 0;
        $donorCount = 0;

        foreach ($legacyUsers as $user) {
            $isAdmin = (bool) $user->getAttribute('is_admin');
            $newRole = $isAdmin ? 'admin' : 'donor';

            $rows[] = [
                'id' => $user->getKey(),
                'email' => $user->email,
                'current_role' => $user->role ?? '<missing>',
                'is_admin' => $isAdmin ? 'true' : 'false',
                'assigned_role' => $newRole,
            ];

            if ($isAdmin) {
                $adminCount++;
            } else {
                $donorCount++;
            }
        }

        $this->table(
            ['ID', 'Email', 'Current role', 'Legacy is_admin', 'Assigned role'],
            $rows
        );

        if ($dryRun) {
            $this->info('Dry run complete. No records were modified.');
            return Command::SUCCESS;
        }

        if (! $force && ! $this->confirm('Apply these role updates to the database?')) {
            $this->info('Backfill cancelled.');
            return Command::SUCCESS;
        }

        foreach ($legacyUsers as $user) {
            $isAdmin = (bool) $user->getAttribute('is_admin');
            $user->role = $isAdmin ? 'admin' : 'donor';
            $user->save();
        }

        $this->info("Backfilled {$adminCount} admin(s) and {$donorCount} donor(s).");

        return Command::SUCCESS;
    }
}
