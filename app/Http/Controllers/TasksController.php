<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tasks\DeleteRequest;
use App\Http\Requests\Tasks\FetchRequest;
use App\Http\Requests\Tasks\ShowRequest;
use App\Http\Requests\Tasks\StoreRequest;
use App\Http\Requests\Tasks\UpdateRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    public function index(FetchRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $tasks = Task::ofUser($user)
            ->orderByDesc('created_at')
            ->when(
                $request->shouldPaginate(),
                fn ($query) => $query->paginate($request->perPage()),
                fn ($query) => $query->simplePaginate($request->perPage())
            );

        return TaskResource::collection($tasks);
    }

    public function show(ShowRequest $request, Task $task)
    {
        return TaskResource::make($task);
    }

    public function store(StoreRequest $request) : Response
    {
        Task::query()->create($request->payload());

        return response()->noContent();
    }

    public function update(UpdateRequest $request, Task $task) : TaskResource
    {
        $task->update($request->payload());

        return TaskResource::make($task->fresh());
    }

    public function destroy(DeleteRequest $request, Task $task) : Response
    {
        $task->delete();

        return response()->noContent();
    }
}
