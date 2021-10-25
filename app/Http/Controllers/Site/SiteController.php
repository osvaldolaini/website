<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Config;
use App\Model\Admin\ConfigAddress;

use App\Model\Admin\Partner;

class SiteController extends Controller
{
    public function index ()
    {
        $partners = Partner::where('active',1)->get();
        $config = Config::get()->first();
        return view('site.index',[
            'title_postfix' => '',
            'config' =>  $config,
            'partners' =>  $partners,
        ]);
    }
}
