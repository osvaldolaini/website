<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Model\Admin\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialMediaController extends Controller
{
    //navegação
    private $navigation = array('title'=>'Mídias sociais','link'=>'socialMedia.index');
    private $new_navigation = array('title'=>'Nova mídia social ','link'=>'socialMedia.create');
    //textos para as mensagens e títulos
    private $configs = array(
        'new'                   => 'Nova mídia social ',
        'msg-success-save'      => 'Mídia social cadastrada com sucesso',
        'msg-error-save'        => 'Não foi possivel cadastrar a mídia social',
        'msg-success-delete'    => 'Mídia social excluida com sucesso',
        'msg-error-delete'      => 'Não foi possivel excluir a mídia social',
        'msg-not-found'         => 'Mídia social não encontrada',
        'location'              => 'midias-sociais',
    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $socialMedias = SocialMedia::all();
        $data[]=array(null,null, null,null);
        if (isset($socialMedias)) {
            $data=array();
            foreach ($socialMedias as $socialMedia) {
                $buttons = Functions::buttons($socialMedia->id,10,$this->configs['location'],true);
                $data[]=array(
                    $socialMedia->title,
                    '<div class="btn btn-xs btn-primary text-white mx-1" ><i class="fab fa-lg '.$socialMedia->icon.'"></i></div>',
                    Functions::status($socialMedia->active),
                    $buttons,
                );
            }
        }

        return view('admin.socialMedia.listAll',[
            'title_postfix' => 'Mídias sociais',
            'navigation'    => $this->new_navigation,
            'data'          => $data,
            'accesslevel'   => 10,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.socialMedia.form',[
            'title_postfix'     => $this->configs['new'],
            'navigation'        => $this->navigation,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:social_media',
        ]);

        $create = new SocialMedia();
        //Dados principais
        $create->title = $request->title;
        $create->active = $request->active;
        $create->link = $request->link;
        $create->icon = $request->icon;
        $create->created_by = Auth::user()->name;

        if($create->save()){
            return response()->json(
                [
                    'success' => true,
                    'location'=> url($this->configs['location']),
                    'message' => $this->configs['msg-success-save']
                ]
            );
        }else{
            return response()->json(
                [
                    'success' => false,
                    'message' => $this->configs['msg-error-save']
                ]
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Admin\SocialMedia  $socialMedia
     * @return \Illuminate\Http\Response
     */
    public function show(SocialMedia $socialMedia)
    {
        if($socialMedia){
            $data = array(
                'title' => $socialMedia->title,
                'body'  => array(
                    'Mídia'         => $socialMedia->title,
                    'Visualizações'     => $socialMedia->clicks,
                    'Criado em'         => ($socialMedia->created_at ? date( 'd/m/Y H:i' , strtotime($socialMedia->created_at)) : ""),
                    'Criado por'        => $socialMedia->created_by,
                    'Atualizado em'     => ($socialMedia->updated_at ? date( 'd/m/Y H:i' , strtotime($socialMedia->updated_at)) : ""),
                    'Atualizado por'    => $socialMedia->updated_by,
                )
            );
            return response()->json(
                [
                    'success' => true,
                    'data' => $data
                ]
            );
        }else{
            return response()->json(
                [
                    'success' => false,
                    'message' => $this->configs['msg-not-found']
                ]
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Admin\SocialMedia  $socialMedia
     * @return \Illuminate\Http\Response
     */
    public function edit(SocialMedia $socialMedia)
    {
        return view('admin.socialMedia.form',[
            'title_postfix'     => $socialMedia->title,
            'navigation'        => $this->navigation,
            'data'              => $socialMedia
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Admin\SocialMedia  $socialMedia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SocialMedia $socialMedia)
    {
        $request->validate([
            'title' => 'required',
        ]);

        //Dados principais
        $socialMedia->title = $request->title;
        $socialMedia->active = $request->active;
        $socialMedia->link = $request->link;
        $socialMedia->icon = $request->icon;
        $socialMedia->updated_because = $request->updated_because;
        $socialMedia->updated_by = Auth::user()->name;

        if($socialMedia->save()){
            return response()->json(
                [
                    'success' => true,
                    'location'=> url($this->configs['location']),
                    'message' => $this->configs['msg-success-save']
                ]
            );
        }else{
            return response()->json(
                [
                    'success' => false,
                    'message' => $this->configs['msg-error-save']
                ]
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Admin\SocialMedia  $socialMedia
     * @return \Illuminate\Http\Response
     */
    public function destroy(SocialMedia $socialMedia, Request $request)
    {
        $socialMedia->active = '3';
        $socialMedia->deleted_because = $request->motive;
        $socialMedia->deleted_by = Auth::user()->name;
        $socialMedia->deleted_at = date( 'Y-m-d H:i:s');

        if($socialMedia->save()){
            return response()->json(
                [
                    'success'   => true,
                    'location'  => url($this->configs['location']),
                    'message'   => $this->configs['msg-success-delete']
                ]
            );
        }else{
            return response()->json(
                [
                    'success' => false,
                    'message' => $this->configs['msg-error-delete']
                ]
            );
        }
    }
}
