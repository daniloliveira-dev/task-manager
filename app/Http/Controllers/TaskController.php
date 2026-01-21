<?php

namespace App\Http\Controllers;

use App\Http\Repositories\TaskRepository as TaskRepository;
use Illuminate\Http\Request;
use App\Http\Helpers\ValidationHelper as ValidationHelper;

class TaskController extends Controller
{
    public function index(TaskRepository $task)
    {
        return $task->listTasks();
    }

    public function show(TaskRepository $task, $id)
    {
        try {
            return $task->returnTaskById($id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Task not found', 'error' => $e->getMessage()], 400);
        }
    }

    public function store(TaskRepository $task, ValidationHelper $validation, Request $request)
    {
        try {
            $validate = $validation->validation($request, [
                'title' => 'string|max:255',
                'description' => 'string|max:255',
                'completed' => 'boolean',
            ]);

            $create = $task->createNewTask($validate);
            if ($create) {
                return response()->json(['message' => 'Task created successfully'], 201);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Task not created', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(TaskRepository $task, ValidationHelper $validation, Request $request, $id)
    {
        try {
            $validate = $validation->validation($request, [
                'title' => 'string|max:255',
                'description' => 'string|max:255',
                'completed' => 'boolean',
            ]);

            $updated = $task->updateTask($id, $validate);
            if ($updated) {
                return response()->json(['message' => 'Task updated successfully'], 200);
            }
            return response()->json(['message' => 'Task not updated'], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Task not found', 'error' => $e->getMessage()], 404);
        }
    }

    public function destroy(TaskRepository $task, $id)
    {
        try {
            $deleted = $task->deleteTask($id);
            if ($deleted) {
                return response()->json(['message' => 'Task deleted successfully'], 200);
            }
            return response()->json(['message' => 'Task not deleted'], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Task not found', 'error' => $e->getMessage()], 500);
        }
    }
}
