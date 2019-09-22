<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    /**
     * Contrôleur d'upload d'image via wysiwyg.
     *
     * @param Request $request
     *
     * @return array
     */
    public function upload(Request $request)
    {
        if ($file = $request->file('upload')) {
            $path = $file->storePublicly('uploads', ['disk' => 'public']);

            return [
                'uploaded' => true,
                'url'      => "/storage/$path",
            ];
        }

        return [
            'uploaded' => false,
        ];
    }
}
