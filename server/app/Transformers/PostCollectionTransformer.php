<?php

namespace App\Transformers;

use League\Fractal;
use App\Models\Post;
use Coduo\PHPHumanizer\StringHumanizer;

/**
 * @OA\Schema(schema="PostCollection")
 */
class PostCollectionTransformer extends Fractal\TransformerAbstract
{
    /**
     * @OA\Property(property="title", type="string")
     * @OA\Property(property="summary", type="string")
     * @OA\Property(property="featured_image", type="string", format="uri")
     * @OA\Property(property="publication_date", type="string", format="date-time")
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
}
