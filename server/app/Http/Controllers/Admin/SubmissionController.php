<?php

namespace App\Http\Controllers\Admin;

use App\Models\Submission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubmissionController extends Controller
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
        return datatables(Submission::whereType($request->get('type')))
            ->columns([
                'id',
                'data',
                'created_at',
            ])
            ->searchables([
                'data',
            ])
            ->perform();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Submission $submission
     *
     * @return Submission
     */
    public function show(Submission $submission)
    {
        return $submission;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Submission $submission
     *
     * @throws \Exception
     *
     * @return array
     */
    public function destroy(Submission $submission)
    {
        $submission->delete();

        return [
            'message' => __('crud.actions.deleted'),
        ];
    }
}
