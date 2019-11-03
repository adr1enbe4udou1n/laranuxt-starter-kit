<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Exceptions\DomainException;
use App\Http\Controllers\Controller;
use App\Services\UserImpersonnation;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return datatables(User::query())
            ->columns([
                'id',
                'name',
                'email',
                'roles',
                'active',
                'last_access_at',
                'created_at',
                'updated_at',
            ])
            ->searchables([
                'name',
                'email',
            ])
            ->export(UsersExport::class, 'users')
            ->perform();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     *
     * @return User
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     *
     * @throws \Exception
     *
     * @return array
     */
    public function store(UserStoreRequest $request)
    {
        /** @var User $user */
        $user = User::make($request->all());

        $user->saveWithPassword(
            $request->input('reset_password')
        );

        return [
            'model'   => $user,
            'message' => __('crud.actions.created'),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\User  $user
     * @param UserUpdateRequest $request
     *
     * @throws \Exception
     *
     * @return array
     */
    public function update(User $user, UserUpdateRequest $request)
    {
        if ($user->is_owner) {
            throw new DomainException(__('exceptions.users.cannot_edit_owner'));
        }

        $user->fill($request->all());

        $user->saveWithPassword(
            $request->input('reset_password')
        );

        return [
            'model'   => $user,
            'message' => __('crud.actions.updated'),
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     *
     * @throws \Exception
     *
     * @return array
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            throw new DomainException(__('exceptions.users.cannot_delete_yourself'));
        }

        if ($user->is_owner) {
            throw new DomainException(__('exceptions.users.cannot_delete_owner'));
        }

        $user->delete();

        return [
            'message' => __('crud.actions.deleted'),
        ];
    }

    /**
     * @param \App\Models\User $user
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function impersonate(User $user)
    {
        abort_if(! auth()->user()->is_admin, 403);

        app(UserImpersonnation::class)->impersonate($user);

        return redirect(config('app.admin_path'));
    }
}
