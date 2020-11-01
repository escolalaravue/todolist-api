<?php

namespace App\Policies;

use App\TodoTask;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoTaskPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param User $user
     * @param TodoTask $todoTask
     * @return bool
     */
    public function update(User $user, TodoTask $todoTask)
    {
        return $user->id === $todoTask->todo->user_id;
    }

    /**
     * @param User $user
     * @param TodoTask $todoTask
     * @return bool
     */
    public function destroy(User $user, TodoTask $todoTask)
    {
        return $user->id === $todoTask->todo->user_id;
    }



}
