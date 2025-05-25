<?php

namespace App\Observers;

use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     * Logs info when a task is created.
     */
    public function created(Task $task): void
    {
        Log::info("Task created: ID {$task->id}, Title: {$task->title}, Project ID: {$task->project_id}");
    }

    /**
     * Handle the Task "updated" event.
     * Logs info with task changes when a task is updated.
     */
    public function updated(Task $task): void
    {
        Log::info("Task updated:", [
            'id' => $task->id,
            'title' => $task->title,
            'changes' => $task->getChanges(),
        ]);
    }

    /**
     * Handle the Task "deleted" event.
     * Logs info when a task is deleted.
     */
    public function deleted(Task $task): void
    {
        Log::info("Task deleted: ID {$task->id}, Title: {$task->title}");
    }

    /**
     * Handle the Task "restored" event.
     * This method is called when a soft-deleted task is restored.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     * This method is called when a task is permanently deleted.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
