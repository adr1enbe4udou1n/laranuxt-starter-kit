<?php

namespace App\Api\Controllers;

use App\Models\Tag;
use App\Transformers\TagTransformer;

class TagController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/cms/tags",
     *     tags={"cms"},
     *     summary="Tags",
     *     description="Tags",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     )
     * )
     *
     * @return \Spatie\Fractal\Fractal
     */
    public function index()
    {
        return fractal(Tag::all(), new TagTransformer());
    }

    /**
     * @OA\Get(
     *     path="/cms/tags/{slug}",
     *     tags={"cms"},
     *     summary="Tag detail",
     *     description="Tag detail",
     *     @OA\Parameter(ref="#/components/parameters/slug"),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     )
     * )
     *
     * @param \App\Models\Tag $tag
     *
     * @return \Spatie\Fractal\Fractal
     */
    public function show(Tag $tag)
    {
        return fractal($tag, new TagTransformer());
    }
}
