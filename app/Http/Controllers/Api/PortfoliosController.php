<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Admin\Portfolio;
use Illuminate\Http\Request;

class portfoliosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $works = Portfolio::select('id','link','slug','image')->where('active',1)
        ->inRandomOrder()
        ->limit(6)
        ->get();

        $apiPortfolio = array();
        foreach ($works as $work) {

            $apiPortfolio[]=array(
                'webp'  => url('storage/images/portfolios/'.$work->id.'_thumbnail.webp'),
                'jpg'   => url('storage/images/portfolios/'.$work->image),
                'link'  => $work->link,
                'slug'  => $work->slug,
            );
        }

        if(isset($apiPortfolio)){
            shuffle($apiPortfolio);
            return response()->json(
                [
                    'success'=> true,
                    'data'   => $apiPortfolio,
                ]
            );
        }else{
            return response()->json(
                [
                    'success'=> false,
                    'error'=> false,
                ]
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Admin\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function show(Portfolio $portfolio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Admin\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function edit(Portfolio $portfolio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Admin\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Admin\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Portfolio $portfolio)
    {
        //
    }
}
