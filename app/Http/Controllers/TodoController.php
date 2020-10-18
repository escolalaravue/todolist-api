<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoStoreRequest;
use App\Http\Resources\TodoResource;
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
     * @param TodoStoreRequest $request
     * @return TodoResource
     */
    public function store(TodoStoreRequest $request)
    {
        $input = $request->validated();
        $todo = auth()->user()->todos()->create($input);

        return new TodoResource($todo);
    }
}
