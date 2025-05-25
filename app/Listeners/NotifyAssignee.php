<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NotifyAssignee
{
    /**
     * Create a new event listener instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the TaskCreated event.
     * Logs notification if the task has an assignee.
     */
    public function handle(TaskCreated $event): void
    {
        $task = $event->task;

        if ($task->assignee_id) {
            Log::info("Notify assignee: Task {$task->id} assigned to {$task->assignee_to}");
        }
    }
}
