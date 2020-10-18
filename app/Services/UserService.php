<?php


namespace App\Services;


use App\Exceptions\UserHasBeenTakenException;
use App\User;

class UserService
{
    /**
     * @param User $user
     * @param array $input
     * @return User|null
     * @throws UserHasBeenTakenException
     */
    public function update(User $user, array $input)
    {
        if (!empty($input['email']) && User::where('email', $input['email'])->exists()) {
            throw new UserHasBeenTakenException();
        }

        if (!empty($input['password'])) {
            $input['password'] = bcrypt($input['password']);
        }

        $user->fill($input);
        $user->save();

        return $user->fresh();
    }
}
