<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin\Alert;
use Illuminate\Http\Request;

use App\Model\Admin\Article;
use App\Model\Admin\Email;
use App\Model\Admin\Partner;
use App\Model\Admin\SocialMedia;
use App\Model\Admin\Subscriber;
use App\Model\Admin\View;
use DateTime;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $alerts         = Alert::where('active', 1)->count();
        $articles       = Article::where('active', 1)->count();
        $emails         = Email::count();
        $partners       = Partner::where('active', 1)->count();
        $socialMedias   = SocialMedia::where('active', 1)->count();
        $subscribers    = Subscriber::where('active', 1)->count();
        $newEmail       = Email::where('active', 1)->count();

        $pag = array();
        $pages = View::select('page')->groupBy('page')->get();
        foreach ($pages as $key) {
            $link = '';
            $page = '';
            $d = explode('/',$key->page);
            for ($i=3; $i < count($d); $i++) {
                $page .= $d[$i].' > ';
                $link .= $d[$i].'/';
            }
            if($d[3] == ''){
                $cat = 'home';
            }else{
                $cat =$d[3];
            }
            $p[]=array(
                'qtd'       => View::where('page', $key->page)->count(),
                'link'      => $link,
                'page'      => mb_strtoupper($page),
                'category'  => mb_strtoupper($cat),
            );
        }
        if ($p != ''){
            array_multisort($p,SORT_DESC);
            array_slice($p, 0, 2);
        }
        $top = count($p);
        if ($top > 5) {
            $top = 4;
        }
        for ($i=0; $i < $top; $i++) {
            $pag[]=array(
                'pos'       => $i+1,
                'qtd'       => $p[$i]['qtd'],
                'link'      => substr($p[$i]['link'], 0, -1),
                'page'      => substr($p[$i]['page'], 0, -2),
                'category'  => $p[$i]['category'],
            );
        }
        /*echo '<pre>';
        print_r($pag);
        exit;*/

        return view('admin.home',[
            'alerts'        => $alerts,
            'articles'      => $articles,
            'emails'        => $emails,
            'newEmail'      => $newEmail,
            'partners'      => $partners,
            'socialMedias'  => $socialMedias,
            'subscribers'   => $subscribers,
            'pages'         => $pag,
        ]);
    }
}
