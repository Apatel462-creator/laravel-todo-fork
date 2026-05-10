<?php

namespace Tests\Unit;

use App\Models\Todo;
use App\Services\TodoService;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class TodoServiceTest extends TestCase
{
    protected TodoService $todoService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->todoService = new TodoService();
    }

    /**
     * Test progress calculation
     */
    public function test_calculate_progress_returns_correct_percentage(): void
    {
        $todos = [
            ['is_completed' => true],
            ['is_completed' => true],
            ['is_completed' => false],
        ];

        $progress = $this->todoService
            ->calculateProgress($todos);

        $this->assertEquals(66, $progress);
    }

    /**
     * Test progress returns zero for empty array
     */
    public function test_calculate_progress_returns_zero_for_empty_todos(): void
    {
        $progress = $this->todoService
            ->calculateProgress([]);

        $this->assertEquals(0, $progress);
    }

    /**
     * Test overdue todo
     */
    public function test_is_overdue_returns_true_when_due_date_passed(): void
    {
        $todo = new Todo([
            'due_date' => Carbon::yesterday(),
            'is_completed' => false,
        ]);

        $result = $this->todoService
            ->isOverdue($todo);

        $this->assertTrue($result);
    }

    /**
     * Test completed todo is not overdue
     */
    public function test_completed_todo_is_not_overdue(): void
    {
        $todo = new Todo([
            'due_date' => Carbon::yesterday(),
            'is_completed' => true,
        ]);

        $result = $this->todoService
            ->isOverdue($todo);

        $this->assertFalse($result);
    }

    /**
     * Test todo without due date
     */
    public function test_todo_without_due_date_is_not_overdue(): void
    {
        $todo = new Todo([
            'due_date' => null,
            'is_completed' => false,
        ]);

        $result = $this->todoService
            ->isOverdue($todo);

        $this->assertFalse($result);
    }

    /**
     * Test status labels
     */
    public function test_status_label_returns_correct_value(): void
    {
        $this->assertEquals(
            'Pending',
            $this->todoService->statusLabel('pending')
        );

        $this->assertEquals(
            'Completed',
            $this->todoService->statusLabel('completed')
        );

        $this->assertEquals(
            'Unknown',
            $this->todoService->statusLabel('random')
        );
    }

    /**
     * Test completed todo count
     */
    public function test_completed_count_returns_correct_total(): void
    {
        $todos = [
            ['is_completed' => true],
            ['is_completed' => true],
            ['is_completed' => false],
        ];

        $count = $this->todoService
            ->completedCount($todos);

        $this->assertEquals(2, $count);
    }

    /**
     * Test sorting by priority
     */
    public function test_sort_by_priority_works_correctly(): void
    {
        $todos = [
            [
                'title' => 'Task 1',
                'priority' => 'medium',
            ],
            [
                'title' => 'Task 2',
                'priority' => 'urgent',
            ],
            [
                'title' => 'Task 3',
                'priority' => 'low',
            ],
        ];

        $sorted = $this->todoService
            ->sortByPriority($todos);

        $this->assertEquals(
            'urgent',
            $sorted[0]['priority']
        );

        $this->assertEquals(
            'medium',
            $sorted[1]['priority']
        );

        $this->assertEquals(
            'low',
            $sorted[2]['priority']
        );
    }
}
