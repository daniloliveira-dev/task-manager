<?php

namespace App\Http\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository
{
    public function listTasks(): Collection
    {
        return Task::all();
    }

    public function returnTaskById($id): Task
    {
        $task = Task::findOrFail($id);
        return $task;
    }

    public function findTaskById($id): Task
    {
        return Task::findOrFail($id);
    }

    public function createNewTask($array): Task
    {
        return Task::create($array);
    }

    public function updateTask($id, $array): bool
    {
        return Task::findOrfail($id)->update($array);
    }

    public function deleteTask($id): bool
    {
        return Task::findOrFail($id)->delete();
    }
}
