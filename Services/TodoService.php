<?php

namespace App\Services;

use App\Models\Todo;

class TodoService
{
    /**
     * Calculate completion percentage
     */
    public function calculateProgress(array $todos): int
    {
        $total = count($todos);

        if ($total === 0) {
            return 0;
        }

        $completed = collect($todos)
            ->where('is_completed', true)
            ->count();

        return (int) floor(($completed / $total) * 100);
    }

    /**
     * Check if todo is overdue
     */
    public function isOverdue(Todo $todo): bool
    {
        if (!$todo->due_date) {
            return false;
        }

        return now()->gt($todo->due_date)
            && !$todo->is_completed;
    }

    /**
     * Generate status label
     */
    public function statusLabel(string $status): string
    {
        return match ($status) {
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            default => 'Unknown',
        };
    }

    /**
     * Count completed todos
     */
    public function completedCount(array $todos): int
    {
        return collect($todos)
            ->where('is_completed', true)
            ->count();
    }

    /**
     * Sort todos by priority
     */
    public function sortByPriority(array $todos): array
    {
        $priorityOrder = [
            'urgent' => 1,
            'high' => 2,
            'medium' => 3,
            'low' => 4,
        ];

        return collect($todos)
            ->sortBy(fn($todo) => $priorityOrder[$todo['priority']] ?? 999)
            ->values()
            ->toArray();
    }
}
