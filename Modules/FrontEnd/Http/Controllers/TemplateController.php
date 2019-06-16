<?php
namespace Modules\FrontEnd\Http\Controllers;

use App\Http\Controllers\Controller;

class TemplateController extends Controller{
    public  function index(){
        return view('frontend::src.template.index');
    }
}