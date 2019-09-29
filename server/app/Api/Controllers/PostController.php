<?php

namespace App\Api\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Transformers\PostTransformer;
use App\Transformers\PostCollectionTransformer;

class PostController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/cms/posts",
     *     tags={"cms"},
     *     operationId="getPosts",
     *     summary="Posts",
     *     description="Posts",
     *     @OA\Parameter(ref="#/components/parameters/page"),
     *     @OA\Parameter(ref="#/components/parameters/perPage"),
     *     @OA\Parameter(
     *         name="tags[]",
     *         description="Filter by tags",
     *         in="query",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="string"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/PostCollection")
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(
     *                     property="pagination",
     *                     ref="#/components/schemas/Pagination"
     *                 )
     *             )
     *         )
     *     )
     * )
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Spatie\Fractal\Fractal
     */
    public function index(Request $request)
    {
        $query = Post::posts()->published();

        if ($tags = $request->parseArray('tags')) {
            $query->withAnyTags($tags);
        }

        return fractal(
            $query->paginate($request->get('perPage')),
            new PostCollectionTransformer()
        );
    }

    /**
     * @OA\Get(
     *     path="/cms/posts/{slug}",
     *     tags={"cms"},
     *     operationId="getPost",
     *     summary="Post detail",
     *     description="Post detail",
     *     @OA\Parameter(ref="#/components/parameters/slug"),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     )
     * )
     *
     * @param \App\Models\Post $post
     *
     * @return \Spatie\Fractal\Fractal
     */
    public function show(Post $post)
    {
        return fractal($post, new PostTransformer());
    }
}
