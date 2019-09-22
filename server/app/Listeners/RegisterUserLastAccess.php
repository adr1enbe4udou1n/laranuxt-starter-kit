<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Auth\Events\Login;

class RegisterUserLastAccess
{
    /**
     * @param Login $event
     */
    public function handle(Login $event)
    {
        /** @var User $user */
        $user = $event->user;

        $user->last_access_at = Carbon::now();
        $user->save();
    }
}
