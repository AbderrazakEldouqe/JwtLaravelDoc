<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Http\Requests\TaskFormRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Support\Facades\App;
use JWTAuth;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    /**
     * @var
     */
    protected $user;

    /**
     * TaskController constructor.
     */
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $tasks = $this->user->tasks()->get();

        return TaskResource::collection($tasks);
    }


    public function store(TaskFormRequest $request)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;

        if ($this->user->tasks()->save($task))
            return new TaskResource($task);
        else
            return AppHelper::storeError('task');
    }

    public function show($id)
    {
        $task = $this->user->tasks()->where('task_id_public', '=', $id)->first();

        if (!$task) {
            return AppHelper::notFoundError($id, 'task');
        }
        return new TaskResource($task);
    }

    public function update(Request $request, $id)
    {
        $task = $this->user->tasks()->where('task_id_public', '=', $id)->first();

        if (!$task) {
            return AppHelper::notFoundError($id, 'task');
        }

        $updated = $task->fill($request->all())->save();

        if ($updated) {
            return new TaskResource($task);
        } else {
            return AppHelper::updateError($id, 'task');
        }
    }


    public function destroy($id)
    {
        $task = $this->user->tasks()->where('task_id_public', '=', $id)->first();

        if (!$task) {
            return AppHelper::notFoundError($id, 'task');
        }

        if ($task->delete()) {
            return AppHelper::deleteSuccess($id, 'task');
        } else {
            return AppHelper::deleteError($id, 'task');
        }
    }
}
