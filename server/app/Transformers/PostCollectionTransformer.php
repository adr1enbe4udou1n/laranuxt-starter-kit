<?php

namespace App\Transformers;

use League\Fractal;
use App\Models\Post;
use OpenApi\Annotations as OA;
use Coduo\PHPHumanizer\StringHumanizer;

/**
 * @OA\Schema(schema="PostCollection")
 */
class PostCollectionTransformer extends Fractal\TransformerAbstract
{
    protected $defaultIncludes = [
        'tags',
    ];

    /**
     * @OA\Property(property="title", type="string")
     * @OA\Property(property="summary", type="string")
     * @OA\Property(property="featured_image", type="string", format="uri")
     * @OA\Property(property="publication_date", type="string", format="date-time")
     * @OA\Property(property="slug", type="string")
     * @OA\Property(property="url", type="string")
     * @OA\Property(
     *     property="tags",
     *     type="object",
     *     @OA\Property(
     *         property="data",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/Tag")
     *     )
     * )
     *
     * @param Post $post
     *
     * @return array
     */
    public function transform(Post $post)
    {
        return [
            'title'              => $post->title,
            'summary'            => StringHumanizer::truncateHtml($post->summary ?: $post->body, 200, '', '...'),
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
