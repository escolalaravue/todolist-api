<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoStoreRequest;
use App\Http\Requests\TodoTaskStoreRequest;
use App\Http\Requests\TodoUpdateRequest;
use App\Http\Resources\TodoResource;
use App\Http\Resources\TodoTaskResource;
use App\Todo;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TodoController extends Controller
{
    /**
     * TodoController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index()
    {
         return TodoResource::collection(auth()->user()->todos);
    }

    /**
     * @param Todo $todo
     * @return TodoResource
     * @throws AuthorizationException
     */
    public function show(Todo $todo)
    {
        $this->authorize('view', $todo);

        $todo->load('tasks');
        return new TodoResource($todo);
    }

    /**
     * @param TodoStoreRequest $request
     * @return TodoResource
     */
    public function store(TodoStoreRequest $request)
    {
        $input = $request->validated();
        $todo = auth()->user()->todos()->create($input);

        return new TodoResource($todo);
    }

    /**
     * @param Todo $todo
     * @param TodoUpdateRequest $request
     * @return TodoResource
     * @throws AuthorizationException
     */
    public function update(Todo $todo, TodoUpdateRequest $request)
    {
        $this->authorize('update', $todo);

        $input = $request->validated();

        $todo->fill($input);
        $todo->save();

        return new TodoResource($todo->fresh());
    }

    /**
     * @param Todo $todo
     * @throws \Exception
     */
    public function destroy(Todo $todo)
    {
        $this->authorize('destroy', $todo);

        $todo->delete();
    }

    /**
     * @param Todo $todo
     * @param TodoTaskStoreRequest $request
     * @return TodoTaskResource
     * @throws AuthorizationException
     */
    public function addTask(Todo $todo, TodoTaskStoreRequest $request)
    {
        $this->authorize('addTask', $todo);

        $input = $request->validated();
        $todoTask = $todo->tasks()->create($input);

        return new TodoTaskResource($todoTask);
    }
}
