<?php

namespace App\Transformers;

use League\Fractal;
use App\Models\Post;
use Coduo\PHPHumanizer\StringHumanizer;

class PostCollectionTransformer extends Fractal\TransformerAbstract
{
    protected $defaultIncludes = [
        'tags',
    ];

    public function transform(Post $post)
    {
        return [
            'title'              => $post->title,
            'summary'            => StringHumanizer::truncateHtml($post->summary ?: $post->body, 80, '', '...'),
            'featured_image'     => $post->featured_image,
            'publication_date'   => $post->publication_date,
            'slug'               => $post->slug,
            'url'                => $post->url,
            'links'              => [
                'self' => route('api.cms.posts.show', $post->slug),
            ],
        ];
    }

    /**
     * Include Tags.
     *
     * @param \App\Models\Post $post
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeTags(Post $post)
    {
        return $this->collection($post->tagsWithType(), new TagTransformer());
    }
}
