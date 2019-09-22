<?php

namespace App\Transformers;

use App\Models\Tag;
use League\Fractal;

class TagTransformer extends Fractal\TransformerAbstract
{
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
