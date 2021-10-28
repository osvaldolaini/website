<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Marketing\Hotmart;
use App\Model\Marketing\Eduzz;
use App\Model\Marketing\Monetizze;
use App\Model\Admin\Config;
use App\Model\Marketing\CountClickMarketing;

class AdsController extends Controller
{
    public function index()
    {
        $config = Config::get()->first();
        $hotmart    = Hotmart::select('id','link','image','path','description','title','promotion')->where('active',1)->inRandomOrder()->first();
        $monetizze  = Monetizze::select('id','link','image','path','description','title','promotion')->where('active',1)->inRandomOrder()->first();
        $eduzz      = Eduzz::select('id','link','image','path','description','title','promotion')->where('active',1)->inRandomOrder()->first();

        if($hotmart){
            $marketing[]=array(
                'id'            => $hotmart->id,
                'link'          => $hotmart->link,
                'image'         => $hotmart->image,
                'path'          => $hotmart->path,
                'description'   => $hotmart->description,
                'title'         => $hotmart->title,
                'table'         => 'hotmarts',
                'promotion'     => $hotmart->promotion,
            );
        }
        if($monetizze){
            $marketing[]=array(
                'id'            => $monetizze->id,
                'link'          => $monetizze->link,
                'image'         => $monetizze->image,
                'path'          => $monetizze->path,
                'description'   => $monetizze->description,
                'title'         => $monetizze->title,
                'table'         => 'monetizzes',
                'promotion'     => $monetizze->promotion,
            );
        }
        if($eduzz){
            $marketing[]=array(
                'id'            => $eduzz->id,
                'link'          => $eduzz->link,
                'image'         => $eduzz->image,
                'path'          => $eduzz->path,
                'description'   => $eduzz->description,
                'title'         => $eduzz->title,
                'table'         => 'eduzzs',
                'promotion'     => $eduzz->promotion,
            );
        }

        if(isset($marketing)){
            shuffle($marketing);
            $ads = json_encode($marketing[0]);
            $ads = json_decode($ads);
            return view('site.ads',[
                'title_postfix' => '',
                'config' =>  $config,
                'data'   => $ads,
            ]);
            /*return response()->json(
                [
                    'success'=> true,
                    'data'   => $marketing[0],
                ]
            );*/
        }else{
            return response()->json(
                [
                    'error'=> false,
                ]
            );
        }


    }
    public function store(Request $request)
    {

            $create = new CountClickMarketing();
            //Dados principais
            $create->marketing_id       = $request->id;
            $create->marketing_table    = $request->table;
            $create->marketing_page     = $request->page;
            $create->user_device        = $request->plataforma;
            $create->user_ua            = $request->ua;

            if($create->save()){
                return response()->json(
                    [
                        'success'   => true,
                    ]
                );
            }else{
                return response()->json(
                    [
                        'error'   => 'Nenhuma propaganda cadastrada',
                    ]
                );
            }


    }
    public function test()
    {
        $config = Config::get()->first();
        $hotmart    = Hotmart::select('id','link','image','path','description','title','promotion')->where('active',1)->inRandomOrder()->first();
        $monetizze  = Monetizze::select('id','link','image','path','description','title','promotion')->where('active',1)->inRandomOrder()->first();
        $eduzz      = Eduzz::select('id','link','image','path','description','title','promotion')->where('active',1)->inRandomOrder()->first();

        if($hotmart){
            $marketing[]=array(
                'id'            => $hotmart->id,
                'link'          => $hotmart->link,
                'image'         => $hotmart->image,
                'path'          => $hotmart->path,
                'description'   => $hotmart->description,
                'title'         => $hotmart->title,
                'table'         => 'hotmarts',
                'promotion'     => $hotmart->promotion,
            );
        }
        if($monetizze){
            $marketing[]=array(
                'id'            => $monetizze->id,
                'link'          => $monetizze->link,
                'image'         => $monetizze->image,
                'path'          => $monetizze->path,
                'description'   => $monetizze->description,
                'title'         => $monetizze->title,
                'table'         => 'monetizzes',
                'promotion'     => $monetizze->promotion,
            );
        }
        if($eduzz){
            $marketing[]=array(
                'id'            => $eduzz->id,
                'link'          => $eduzz->link,
                'image'         => $eduzz->image,
                'path'          => $eduzz->path,
                'description'   => $eduzz->description,
                'title'         => $eduzz->title,
                'table'         => 'eduzzs',
                'promotion'     => $eduzz->promotion,
            );
        }
        shuffle($marketing);
        $ads = json_encode($marketing[0]);
        $ads = json_decode($ads);
        return view('site.ads',[
            'title_postfix' => '',
            'config' =>  $config,
            'data'   => $ads,
        ]);
    }
}
