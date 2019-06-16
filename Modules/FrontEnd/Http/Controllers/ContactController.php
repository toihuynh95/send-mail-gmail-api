<?php

namespace Modules\FrontEnd\Http\Controllers;

use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function index() {
        return view('frontend::src.contact.index');
    }

}
