<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin\View;
use DateTime;
use Illuminate\Http\Request;

class ChartsController extends Controller
{
    public function first()
    {
        $month = array();
        $views = array();
        for ($i=0; $i < 6; $i++) {
            $m=new DateTime("-".$i." months");
            $month[]=$m->format('Y-m');
         }
         sort($month);
         foreach ($month as $key => $value) {
            $month_br[]=date('M' , strtotime($value));
            $views[] = View::where(View::raw("DATE_FORMAT(created_at, '%Y-%m')"),$value)->count();
         }

         return response()->json(
            [
                'labels'    => $month_br,
                'views'     => $views,
            ]
        );
    }
    public function second()
    {
        $total = View::count();

        $devices = View::where('user_device','Smartphone ou tablet')->count();
        $label ='Smartphone ou tablet';
        $val = ($devices * 100)/$total;

        $name[]= array(
            'name'      => $label,
            'y'         => $val,
            'drilldown' => $label,
        );

        $devices = View::where('user_device','Desktop')->count();
        $label ='Desktop';
        $val = ($devices * 100)/$total;

        $name[]= array(
            'name'      => $label,
            'y'         => $val,
            'drilldown' => $label,
        );

        return response()->json(
            [
                'data'    => $name,
            ]
        );
    }
    public function third()
    {
        $total = View::count();
        $access = View::select('page')->groupBy('page')->get();
        $cat = array();
        foreach ($access as $key) {

            $names = explode('/',$key->page);
            if($names[3]){
                $qry = $names[0].'/'.$names[1].'/'.$names[2].'/'.$names[3];
                $page = $names[3];
            }else{
                $qry = $names[0].'/'.$names[1].'/'.$names[2].'/';
                $page = 'home';
            }
            $views = View::where('page', 'LIKE', "%{$qry}%")->count();
            $val = ($views * 100)/$total;
            $names = explode('/',$key->page);

            if(!in_array($page,$cat)){
                $cat[]=$page;
                $name[]= array(
                    'name'  => mb_strtoupper($page),
                    'y'     => $val
                );
            }
        }

        return response()->json(
            [
                'name'      => $name,
            ]
        );
    }
}
