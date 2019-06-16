<?php
namespace Modules\FrontEnd\Http\Controllers;

use App\Http\Controllers\Controller;

class CampaignController extends Controller{
    public  function index(){
        return view('frontend::src.campaign.index');
    }
}