<?php

namespace App\Policies;


use App\Models\Point;
use App\Models\User;


class PointPolicy
{
    public function update(User $user, Point $point): bool
    {
        return $user->id === $point->user_id;
    }


    public function delete(User $user, Point $point): bool
    {
        return $user->id === $point->user_id;
    }
}
