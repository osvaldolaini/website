<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Admin\Partner;
use Illuminate\Http\Request;

class partnersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partners = Partner::select('id','link','slug','image')->where('active',1)
        ->inRandomOrder()
        ->limit(6)
        ->get();

        $apiPartner = array();
        foreach ($partners as $partner) {

            $apiPartner[]=array(
                'webp'  => url('storage/images/partners/'.$partner->id.'_thumbnail.webp'),
                'jpg'   => url('storage/images/partners/'.$partner->image),
                'link'  => $partner->link,
                'slug'  => $partner->slug,
            );
        }

        if(isset($apiPartner)){
            shuffle($apiPartner);
            return response()->json(
                [
                    'success'=> true,
                    'data'   => $apiPartner,
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
     * @param  \App\Model\Admin\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Admin\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Admin\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partner $partner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Admin\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner)
    {
        //
    }
}
