<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return datatables(Post::whereType($request->get('type')))
            ->columns([
                'id',
                'user_id',
                'title',
                'type',
                'status',
                'is_pinned',
                'slug',
                'publication_date',
                'created_at',
                'updated_at',
            ])
            ->searchables([
                'title',
                'summary',
                'body',
                'user.name',
            ])
            ->perform();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Post $post
     *
     * @return Post
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostStoreRequest $request
     *
     * @throws \Exception
     *
     * @return array
     */
    public function store(PostStoreRequest $request)
    {
        /** @var Post $post */
        $post = Post::create($request->all());
        $post->syncTagsWithType($request->input('tags') ?: []);

        return [
            'model'   => $post,
            'message' => __('crud.actions.created'),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\Post  $post
     * @param PostUpdateRequest $request
     *
     * @throws \Exception
     *
     * @return array
     */
    public function update(Post $post, PostUpdateRequest $request)
    {
        $post->update($request->except('type'));
        $post->syncTagsWithType($request->input('tags') ?: []);

        return [
            'model'   => $post,
            'message' => __('crud.actions.updated'),
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Post $post
     *
     * @throws \Exception
     *
     * @return array
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return [
            'message' => __('crud.actions.deleted'),
        ];
    }
}
