<?php

namespace App\Transformers;

use League\Fractal;
use App\Models\Post;

class PageCollectionTransformer extends Fractal\TransformerAbstract
{
    public function transform(Post $post)
    {
        return [
            'title'              => $post->title,
            'summary'            => $post->summary,
            'featured_image'     => $post->featured_image,
            'publication_date'   => $post->publication_date,
            'slug'               => $post->slug,
            'url'                => $post->url,
            'links'              => [
                'self' => route('api.cms.pages.show', $post->slug),
            ],
        ];
    }
}
