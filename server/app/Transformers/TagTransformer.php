<?php

namespace App\Transformers;

use App\Models\Tag;
use League\Fractal;

/**
 * @OA\Schema(schema="Tag")
 */
class TagTransformer extends Fractal\TransformerAbstract
{
    /**
     * @OA\Property(property="name", type="string")
     * @OA\Property(property="slug", type="string")
     *
     * @param Tag $tag
     *
     * @return array
     */
    public function transform(Tag $tag)
    {
        return [
            'name'             => $tag->name,
            'slug'             => $tag->slug,
            'links'            => [
                'self' => route('api.cms.tags.show', $tag->slug),
            ],
        ];
    }
}
