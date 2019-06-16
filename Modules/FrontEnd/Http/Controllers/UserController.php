<?php

namespace Modules\FrontEnd\Http\Controllers;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index() {
        return view('frontend::src.user.index');
    }

    public function login() {
        return view('frontend::src.user.test');
    }
    public function profile() {
        return view('frontend::src.user.profile');
    }
}
