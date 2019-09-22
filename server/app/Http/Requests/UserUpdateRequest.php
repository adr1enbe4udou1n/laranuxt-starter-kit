<?php

namespace App\Http\Requests;

class UserUpdateRequest extends UserStoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->route('user');

        $rules = parent::rules();

        $rules['email'] = 'required|email|unique:users,email,'.$user->id;

        return $rules;
    }
}
