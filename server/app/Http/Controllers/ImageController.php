<?php

namespace App\Http\Controllers;

use Spatie\Image\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * @param $path
     * @param Request $request
     *
     * @throws \Spatie\Image\Exceptions\InvalidImageDriver
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     *
     * @return mixed
     */
    public function thumbnail($path, Request $request)
    {
        $method = $request->get('method');
        $size = $request->get('size');

        $dimensions = config("image.thumbnails.$size");

        if (! $dimensions) {
            return abort(404);
        }

        $timestamp = filemtime($path);
        $filename = md5("$path-$timestamp-$method-$size").'.'.pathinfo($path, PATHINFO_EXTENSION);
        $thumbnail = "storage/cache/$filename";

        if (! file_exists($thumbnail)) {
            Image::load($path)
                ->useImageDriver(config('image.driver'))
                ->fit($request->get('method'), $dimensions['width'], $dimensions['height'])
                ->optimize()
                ->save($thumbnail);
        }

        return response()
            ->file($thumbnail)
            ->setMaxAge(31536000)
            ->setExpires(date_create()->modify('+1 years'));
    }
}
