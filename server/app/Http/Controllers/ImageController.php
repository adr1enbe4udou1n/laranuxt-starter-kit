<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Glide\ServerFactory;
use League\Glide\Responses\SymfonyResponseFactory;

class ImageController extends Controller
{
    /**
     * @param $path
     * @param Request $request
     *
     * @return mixed
     */
    public function thumbnail($path, Request $request)
    {
        $server = ServerFactory::create([
            'source'   => 'storage',
            'cache'    => 'storage/cache',
            'driver'   => config('image.driver'),
            'presets'  => config('image.presets'),
            'response' => new SymfonyResponseFactory(),
        ]);

        return $server->getImageResponse(str_replace('storage', '', $path), $request->query());
    }
}
