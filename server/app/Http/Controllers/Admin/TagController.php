<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
use App\Http\Controllers\Controller;

class TagController extends Controller
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
        return datatables(Tag::query()
            ->whereType($request->get('type'))
            ->withCount('posts')
        )
            ->columns([
                'id',
                'name',
                'order_column',
                'posts_count',
                'created_at',
                'updated_at',
            ])
            ->searchables([
                'name',
            ])
            ->perform();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Tag $tag
     *
     * @return Tag
     */
    public function show(Tag $tag)
    {
        return $tag;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TagRequest $request
     *
     * @throws \Exception
     *
     * @return array
     */
    public function store(TagRequest $request)
    {
        /** @var Tag $tag */
        $tag = Tag::create($request->input());

        return [
            'model'   => $tag,
            'message' => __('crud.actions.created'),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\Tag $tag
     * @param TagRequest      $request
     *
     * @return array
     */
    public function update(Tag $tag, TagRequest $request)
    {
        $tag->update($request->input());

        return [
            'model'   => $tag,
            'message' => __('crud.actions.updated'),
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Tag $tag
     *
     * @throws \Exception
     *
     * @return array
     */
    public function destroy(Tag $tag)
    {
        $this->authorize('manage-tags');

        $tag->delete();

        return [
            'message' => __('crud.actions.deleted'),
        ];
    }
}
