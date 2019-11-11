<?php

namespace App\Transformers;

use League\Fractal;
use App\Models\Post;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(schema="Page")
 */
class PageTransformer extends Fractal\TransformerAbstract
{
    /**
     * @OA\Property(property="title", type="string")
     * @OA\Property(property="summary", type="string")
     * @OA\Property(property="body", type="string")
     * @OA\Property(property="featured_image", type="string", format="uri")
     * @OA\Property(property="slug", type="string")
     * @OA\Property(property="url", type="string")
     *
     * @param Post $post
     *
     * @return array
     */
    public function transform(Post $post)
    {
        $url = request()->getSchemeAndHttpHost();

        return [
            'title'            => $post->title,
            'summary'          => $post->summary,
            'body'             => str_replace('src="/', "src=\"{$url}/", $post->body),
            'featured_image'   => $post->featured_image,
            'slug'             => $post->slug,
            'url'              => $post->url,
            'links'            => [
                'self' => route('api.cms.pages.show', $post->slug),
            ],
        ];
    }
}
