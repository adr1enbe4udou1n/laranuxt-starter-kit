<?php

namespace App\Http\Requests;

class PostUpdateRequest extends PostStoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        unset($rules['type']);

        return $rules;
    }
}
