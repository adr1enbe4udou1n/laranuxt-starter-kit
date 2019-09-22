<?php

use Illuminate\Support\Str;
use App\Services\Datatables;
use Illuminate\Support\HtmlString;

if (! function_exists('encore_entries')) {
    function encore_entries($entry, $type)
    {
        static $manifest;

        if (! $manifest
            && file_exists($manifestPath = public_path('build/entrypoints.json'))
        ) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
        }

        return collect($manifest['entrypoints'][$entry][$type] ?? [])
            ->map(function ($path) {
                if (Str::startsWith($path, 'build')) {
                    return url('/').'/'.$path;
                }

                return $path;
            })
            ->toArray();
    }
}

if (! function_exists('encore_entry_link_tags')) {
    function encore_entry_link_tags($entry)
    {
        $entries = encore_entries($entry, 'css');

        $html = '';

        foreach ($entries as $path) {
            $html = "<link href=\"$path\" rel=\"stylesheet\">";
        }

        return new HtmlString($html);
    }
}

if (! function_exists('encore_entry_script_tags')) {
    function encore_entry_script_tags($entry)
    {
        $entries = encore_entries($entry, 'js');

        $html = '';

        foreach ($entries as $path) {
            $html = "<script src=\"$path\" defer></script>";
        }

        return new HtmlString($html);
    }
}

if (! function_exists('datatables')) {
    /**
     * @param mixed $source
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return Datatables
     */
    function datatables($source = null)
    {
        if (null === $source) {
            return app(Datatables::class);
        }

        return app(Datatables::class)->make($source);
    }
}
