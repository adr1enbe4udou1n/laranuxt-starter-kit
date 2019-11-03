<?php

namespace App\Http\Controllers;

use App\Utils\EnumUtils;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @throws \ReflectionException
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'locale'           => app()->getLocale(),
            'name'             => config('app.name'),
            'admin_path'       => config('app.admin_path'),
            'user'             => auth()->user(),
            'is_impersonation' => session()->has('admin_user_id') && session()->has('temp_user_id'),
            'usurper_name'     => session()->get('admin_user_name'),
            'enums'            => EnumUtils::all(),
        ];

        return view('home', compact('data'));
    }
}
