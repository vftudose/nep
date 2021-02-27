<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $task1 = new Task([
            'project_id' => 1,
            'name' => 'Go get groceries',
            'description' => 'I should go buy some groceries as I can see that my fridge is empty',
            'status' => Task::STATUS_TODO,
            'attachments' => null,
            'assigned_to' => 1
        ]);

        $task1->save();

        $task2 = new Task([
            'project_id' => 1,
            'name' => 'Put some validation on login component',
            'description' => 'I need to tell the user if the password is wrong',
            'status' => Task::STATUS_TODO,
            'attachments' => null,
            'assigned_to' => 2
        ]);

        $task2->save();

        $task3 = new Task([
            'project_id' => 1,
            'name' => 'Create a way for the user to download the task attachment',
            'description' => 'WE don\'t have that yet',
            'status' => Task::STATUS_TODO,
            'attachments' => null,
            'assigned_to' => 2
        ]);

        $task3->save();

        $task4 = new Task([
            'project_id' => 1,
            'name' => 'Do some proper testing on this app',
            'description' => 'WE don\'t have that yet',
            'status' => Task::STATUS_TODO,
            'attachments' => null,
            'assigned_to' => 2
        ]);

        $task4->save();

        $task5 = new Task([
            'project_id' => 1,
            'name' => 'Make this app responsive',
            'description' => 'I need at least a week to make this app display and work properly',
            'status' => Task::STATUS_TODO,
            'attachments' => null,
            'assigned_to' => 2
        ]);

        $task5->save();

        $task6 = new Task([
            'project_id' => 1,
            'name' => 'Project assignment',
            'description' => 'When the admin creates a task for a user the user is automatically associated with that project. Cool!',
            'status' => Task::STATUS_DONE,
            'attachments' => null,
            'assigned_to' => 2
        ]);

        $task6->save();

        $task7 = new Task([
            'project_id' => 1,
            'name' => 'Drag assignment',
            'description' => 'WHen you drag the task to another column the database is synced also. Cool',
            'status' => Task::STATUS_DONE,
            'attachments' => null,
            'assigned_to' => 2
        ]);

        $task7->save();
    }
}
