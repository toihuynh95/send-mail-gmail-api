<?php

namespace Modules\FrontEnd\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class StatisticController extends Controller
{
    public function index()
    {
        return view('frontend::src.statistic.index');
    }
}
