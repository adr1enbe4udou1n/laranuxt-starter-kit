<?php

namespace App\Api\Controllers;

use App\Models\Post;
use App\Transformers\PageTransformer;
use App\Transformers\PageCollectionTransformer;

class PageController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/cms/pages",
     *     tags={"cms"},
     *     summary="Pages",
     *     description="Pages",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PageCollection")
     *         )
     *     )
     * )
     *
     * @return \Spatie\Fractal\Fractal
     */
    public function index()
    {
        return fractal(
            Post::pages()->published()->get(),
            new PageCollectionTransformer()
        );
    }

    /**
     * @OA\Get(
     *     path="/cms/pages/{slug}",
     *     tags={"cms"},
     *     summary="Page detail",
     *     description="Page detail",
     *     @OA\Parameter(ref="#/components/parameters/slug"),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Page")
     *     )
     * )
     *
     * @param \App\Models\Post $page
     *
     * @return \Spatie\Fractal\Fractal
     */
    public function show(Post $page)
    {
        return fractal($page, new PageTransformer());
    }
}
