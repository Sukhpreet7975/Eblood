<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MigrateLegacyRoles extends Command
{
    protected $signature = 'users:migrate-legacy-roles {--dry-run : Show pending changes without modifying records} {--force : Run without confirmation}';

    protected $description = 'Migrate legacy roles (donor/requester) into unified user role and set is_donor flag for donors.';

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        $force = $this->option('force');

        $legacy = User::whereIn('role', ['donor', 'requester'])->get();

        if ($legacy->isEmpty()) {
            $this->info('No legacy-role users found.');
            return Command::SUCCESS;
        }

        $rows = [];

        foreach ($legacy as $u) {
            $rows[] = [
                'id' => $u->getKey(),
                'email' => $u->email,
                'before_role' => $u->role,
                'is_donor_before' => (string) ($u->is_donor ?? 'false'),
                'after_role' => 'user',
                'is_donor_after' => $u->role === 'donor' ? 'true' : 'false',
            ];
        }

        $this->table(['ID', 'Email', 'Role', 'is_donor (before)', 'Role (after)', 'is_donor (after)'], $rows);

        if ($dryRun) {
            $this->info('Dry run complete. No changes applied.');
            return Command::SUCCESS;
        }

        if (! $force && ! $this->confirm('Apply these updates to convert legacy roles to unified users?')) {
            $this->info('Cancelled by user.');
            return Command::SUCCESS;
        }

        $count = 0;

        foreach ($legacy as $u) {
            if ($u->role === 'donor') {
                $u->is_donor = true;
            }

            $u->role = 'user';
            $u->save();
            $count++;
        }

        $this->info("Updated {$count} user(s).");

        return Command::SUCCESS;
    }
}
