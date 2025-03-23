<?php

namespace App\Jobs\User;

use App\Services\UserActivityService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateActivity implements ShouldQueue
{
    use Queueable;

    private UserActivityService $userActivityService;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->userActivityService = new UserActivityService();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->userActivityService->generateActivities();
    }
}
