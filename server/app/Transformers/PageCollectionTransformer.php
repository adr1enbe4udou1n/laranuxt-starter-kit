<?php

namespace App\Transformers;

use League\Fractal;
use App\Models\Post;

/**
 * @OA\Schema(schema="PageCollection")
 */
class PageCollectionTransformer extends Fractal\TransformerAbstract
{
    /**
     * @OA\Property(property="title", type="string")
     * @OA\Property(property="slug", type="string")
     * @OA\Property(property="url", type="string")
     *
     * @param Post $post
     *
     * @return array
     */
    public function transform(Post $post)
    {
        return [
            'title'              => $post->title,
            'slug'               => $post->slug,
            'url'                => $post->url,
            'links'              => [
                'self' => route('api.cms.pages.show', $post->slug),
            ],
        ];
    }
}
