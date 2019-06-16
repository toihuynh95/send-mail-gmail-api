<?php
namespace Modules\FrontEnd\Http\Controllers;

use App\Http\Controllers\Controller;

class ProjectController extends Controller{
    public  function index(){
        return view('frontend::src.project.index');
    }

    public  function me(){
        return view('frontend::src.project.me');
    }
}
