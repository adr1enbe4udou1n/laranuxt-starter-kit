<?php

namespace App\Services;

use App\Models\User;
use App\Exceptions\DomainException;

class UserImpersonnation
{
    /**
     * @param User $user
     *
     * @throws DomainException
     */
    public function impersonate(User $user)
    {
        if ($user->is_owner) {
            throw new DomainException(__('exceptions.users.cannot_impersonated_owner'));
        }

        $authenticatedUser = auth()->user();
        $admin_user_id = session()->get('admin_user_id');

        if ($admin_user_id || $authenticatedUser->id === $user->id) {
            return;
        }

        session(['admin_user_id' => $authenticatedUser->id]);
        session(['admin_user_name' => $authenticatedUser->name]);
        session(['temp_user_id' => $user->id]);

        auth()->loginUsingId($user->id);
    }

    /**
     * Logout impersonation.
     */
    public function logout()
    {
        if ($admin_user_id = session()->get('admin_user_id')) {
            session()->forget('admin_user_id');
            session()->forget('admin_user_name');
            session()->forget('temp_user_id');

            auth()->loginUsingId((int) $admin_user_id);

            return;
        }

        auth()->logout();
        session()->invalidate();
    }
}
