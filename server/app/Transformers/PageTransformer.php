<?php

namespace App\Transformers;

use App\Models\Post;

class PageTransformer extends PageCollectionTransformer
{
    public function transform(Post $post)
    {
        $url = request()->getSchemeAndHttpHost();

        return [
            'title'            => $post->title,
            'summary'          => $post->summary,
            'body'             => str_replace('src="/', "src=\"{$url}/", $post->body),
            'featured_image'   => $post->featured_image,
            'publication_date' => $post->publication_date,
            'slug'             => $post->slug,
            'url'              => $post->url,
            'links'            => [
                'self' => route('api.cms.pages.show', $post->slug),
            ],
        ];
    }
}
