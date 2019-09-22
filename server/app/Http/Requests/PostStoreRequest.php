<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Models\Enums\PostTypeEnum;
use App\Models\Enums\PublishStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'               => 'required',
            'type'                => [
                'required',
                Rule::in(PostTypeEnum::getValues()),
            ],
            'user_id'             => 'nullable|exists:users,id',
            'featured_image_file' => 'nullable|mimes:jpeg,png',
            'status'              => [
                'required',
                Rule::in(PublishStatusEnum::getValues()),
            ],
            'publication_date'      => 'nullable|date',
            'pinned'                => 'boolean',
            'featured_image_delete' => 'boolean',
        ];
    }
}
