<?php

namespace App\Console\Commands;

use App\Models\Project;
use Illuminate\Console\Command;

class PublishScheduledProjects extends Command
{
    protected $signature = 'statecorps:publish-scheduled';

    protected $description = 'Publish projects whose scheduled publication time has arrived.';

    public function handle(): int
    {
        $count = Project::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '<=', now())
            ->update(['scheduled_at' => null]);

        $this->info("Published {$count} scheduled project(s).");

        return self::SUCCESS;
    }
}
