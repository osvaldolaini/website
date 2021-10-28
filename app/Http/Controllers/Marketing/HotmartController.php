<?php

namespace App\Http\Controllers\Marketing;

use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Model\Marketing\Hotmart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HotmartController extends Controller
{
    //navegação
    private $navigation = array('title'=>'Hotmart afiliações','link'=>'hotmart.index');
    private $new_navigation = array('title'=>'Nova afiliação ','link'=>'hotmart.create');
    //textos para as mensagens e títulos
    private $configs = array(
        'new'                   => 'Nova afiliação ',
        'msg-success-save'      => 'Afiliação cadastrada com sucesso',
        'msg-error-save'        => 'Não foi possivel cadastrar a afiliação',
        'msg-success-delete'    => 'Afiliação excluida com sucesso',
        'msg-error-delete'      => 'Não foi possivel excluir a afiliação',
        'msg-not-found'         => 'Afiliação não encontrada',
        'location'              => 'afiliacoes-hotmart',
    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Hotmart::all();
        $data[]=array(null,null, null);
        if (isset($query)) {
            $data=array();
            foreach ($query as $row) {
                $buttons = Functions::buttons($row->id,10,$this->configs['location'],true);
                $data[]=array(
                    $row->title,
                    Functions::status($row->active),
                    $buttons,
                );
            }
        }

        return view('marketing.hotmart.listAll',[
            'title_postfix' => 'Afiliações Hotmart',
            'navigation'    => $this->new_navigation,
            'data'          => $data,
            'accesslevel'   => 100,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('marketing.hotmart.form',[
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
            'title' => 'required|unique:hotmarts',
            'link' => 'required|unique:hotmarts',
        ]);

        $create = new Hotmart();
        //Dados principais
        $create->title = $request->title;
        $create->active = $request->active;
        $create->link = $request->link;
        $create->description = $request->description;
        $create->path = 'storage/images/hotmarts/';
        $create->created_by = Auth::user()->name;

        if($create->save()){
            if(isset($request->image)){
                Storage::delete(['public/images/hotmarts/'.$create->id.'.jpg', 'public/images/hotmarts/'.$create->id.'.png','public/images/hotmarts/'.$create->id.'.jpeg','public/images/hotmarts/'.$create->id.'.webp']);
                $img= explode('.',$request->image);
                $extension = $img[1];
                $create->image = $create->id.'.'.$extension;
                $create->save();
                /*Move as imagens do arquivo tmp para a pasta do arquivo */
                Storage::move('public/tmp/' . $request->image, 'public/images/hotmarts/'. $create->image);
            }else{
                if(!isset($request->imageRemove)){
                    Storage::delete(['public/images/hotmarts/'.$create->id.'.jpg', 'public/images/hotmarts/'.$create->id.'.png','public/images/hotmarts/'.$create->id.'.jpeg','public/images/hotmarts/'.$create->id.'.webp']);
                    $create->image = null;
                }
            }
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
     * @param  \App\Model\Marketing\Hotmart  $hotmart
     * @return \Illuminate\Http\Response
     */
    public function show(Hotmart $hotmart)
    {
        if($hotmart){
            $data = array(
                'title' => $hotmart->title,
                'body'  => array(
                    'Afiliação'         => $hotmart->title,
                    'Cliques'           => $hotmart->clicks,
                    'Criado em'         => ($hotmart->created_at ? date( 'd/m/Y H:i' , strtotime($hotmart->created_at)) : ""),
                    'Criado por'        => $hotmart->created_by,
                    'Atualizado em'     => ($hotmart->updated_at ? date( 'd/m/Y H:i' , strtotime($hotmart->updated_at)) : ""),
                    'Atualizado por'    => $hotmart->updated_by,
                    'image'             => ($hotmart->image ? url('storage/images/hotmarts/'.$hotmart->image) : url('storage/images/logos/logo.png') ),
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
     * @param  \App\Model\Marketing\Hotmart  $hotmart
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotmart $hotmart)
    {
        return view('marketing.hotmart.form',[
            'title_postfix'     => $hotmart->title,
            'navigation'        => $this->navigation,
            'data'              => $hotmart
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Marketing\Hotmart  $hotmart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hotmart $hotmart)
    {
        $request->validate([
            'title' => 'required',
            'link' => 'required',
            'updated_because' => 'required',
        ]);
        //Dados principais
        $hotmart->title = $request->title;
        $hotmart->active = $request->active;
        $hotmart->link = $request->link;
        $hotmart->description = $request->description;
        $hotmart->updated_because = $request->updated_because;
        $hotmart->updated_by = Auth::user()->name;

        //Imagem
        if(isset($request->image)){
            Storage::delete(['public/images/hotmarts/'.$hotmart->id.'.jpg', 'public/images/hotmarts/'.$hotmart->id.'.png','public/images/hotmarts/'.$hotmart->id.'.jpeg','public/images/hotmarts/'.$hotmart->id.'.webp']);
            $img= explode('.',$request->image);
            $extension = $img[1];
            $hotmart->image = $hotmart->id.'.'.$extension;
            /*Move as imagens do arquivo tmp para a pasta do arquivo */
            Storage::move('public/tmp/' . $request->image, 'public/images/hotmarts/'. $hotmart->image);
        }else{
            if(!isset($request->imageRemove)){
                Storage::delete(['public/images/hotmarts/'.$hotmart->id.'.jpg', 'public/images/hotmarts/'.$hotmart->id.'.png','public/images/hotmarts/'.$hotmart->id.'.jpeg','public/images/hotmarts/'.$hotmart->id.'.webp']);
                $hotmart->image = null;
            }
        }

        if($hotmart->save()){
            return response()->json(
                [
                    'success'   => true,
                    'location'  => url($this->configs['location']),
                    'message'   => $this->configs['msg-success-save']
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
     * @param  \App\Model\Marketing\Hotmart  $hotmart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotmart $hotmart, Request $request)
    {
        $hotmart->active = '3';
        $hotmart->deleted_because = $request->motive;
        $hotmart->deleted_by = Auth::user()->name;
        $hotmart->deleted_at = date( 'Y-m-d H:i:s');

        if($hotmart->save()){
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
