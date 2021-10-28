<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Config;
use App\Model\Admin\ConfigAddress;

use App\Model\Admin\Portfolio;

class SiteController extends Controller
{
    public function index ()
    {
        $works_1 = Portfolio::select('id','link','slug','image','title')->where('active',1)
        ->inRandomOrder()
        ->limit(2)
        ->get();
        $works_2 = Portfolio::select('id','link','slug','image','title')->where('active',1)
        ->inRandomOrder()
        ->limit(2)
        ->get();
        $config = Config::get()->first();

        return view('site.index',[
            'title_postfix' => '',
            'config' =>  $config,
            'works_1' =>  $works_1,
            'works_2' =>  $works_2,
        ]);
    }
}
