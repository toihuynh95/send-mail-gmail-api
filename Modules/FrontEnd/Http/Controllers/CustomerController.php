<?php

namespace Modules\FrontEnd\Http\Controllers;

use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index() {
        return view('frontend::src.customer.index');
    }

}
