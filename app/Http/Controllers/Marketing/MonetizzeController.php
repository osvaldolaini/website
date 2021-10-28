<?php

namespace App\Http\Controllers\Marketing;

use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Model\Marketing\Monetizze;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MonetizzeController extends Controller
{
    //navegação
    private $navigation = array('title'=>'Monetizze afiliações','link'=>'monetizze.index');
    private $new_navigation = array('title'=>'Nova afiliação ','link'=>'monetizze.create');
    //textos para as mensagens e títulos
    private $configs = array(
        'new'                   => 'Nova afiliação ',
        'msg-success-save'      => 'Afiliação cadastrada com sucesso',
        'msg-error-save'        => 'Não foi possivel cadastrar a afiliação',
        'msg-success-delete'    => 'Afiliação excluida com sucesso',
        'msg-error-delete'      => 'Não foi possivel excluir a afiliação',
        'msg-not-found'         => 'Afiliação não encontrada',
        'location'              => 'afiliacoes-monetizze',
    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Monetizze::all();
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

        return view('marketing.monetizze.listAll',[
            'title_postfix' => 'Afiliações Monetizze',
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
        return view('marketing.monetizze.form',[
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
            'title' => 'required|unique:monetizzes',
            'link' => 'required|unique:monetizzes',
        ]);

        $create = new Monetizze();
        //Dados principais
        $create->title = $request->title;
        $create->active = $request->active;
        $create->link = $request->link;
        $create->description = $request->description;
        $create->path = 'storage/images/monetizzes/';
        $create->created_by = Auth::user()->name;

        if($create->save()){
            if(isset($request->image)){
                Storage::delete(['public/images/monetizzes/'.$create->id.'.jpg', 'public/images/monetizzes/'.$create->id.'.png','public/images/monetizzes/'.$create->id.'.jpeg','public/images/monetizzes/'.$create->id.'.webp']);
                $img= explode('.',$request->image);
                $extension = $img[1];
                $create->image = $create->id.'.'.$extension;
                $create->save();
                /*Move as imagens do arquivo tmp para a pasta do arquivo */
                Storage::move('public/tmp/' . $request->image, 'public/images/monetizzes/'. $create->image);
            }else{
                if(!isset($request->imageRemove)){
                    Storage::delete(['public/images/monetizzes/'.$create->id.'.jpg', 'public/images/monetizzes/'.$create->id.'.png','public/images/monetizzes/'.$create->id.'.jpeg','public/images/monetizzes/'.$create->id.'.webp']);
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
     * @param  \App\Model\Marketing\Monetizze  $monetizze
     * @return \Illuminate\Http\Response
     */
    public function show(Monetizze $monetizze)
    {
        if($monetizze){
            $data = array(
                'title' => $monetizze->title,
                'body'  => array(
                    'Afiliação'         => $monetizze->title,
                    'Cliques'           => $monetizze->clicks,
                    'Criado em'         => ($monetizze->created_at ? date( 'd/m/Y H:i' , strtotime($monetizze->created_at)) : ""),
                    'Criado por'        => $monetizze->created_by,
                    'Atualizado em'     => ($monetizze->updated_at ? date( 'd/m/Y H:i' , strtotime($monetizze->updated_at)) : ""),
                    'Atualizado por'    => $monetizze->updated_by,
                    'image'             => ($monetizze->image ? url('storage/images/monetizzes/'.$monetizze->image) : url('storage/images/logos/logo.png') ),
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
     * @param  \App\Model\Marketing\Monetizze  $monetizze
     * @return \Illuminate\Http\Response
     */
    public function edit(Monetizze $monetizze)
    {
        return view('marketing.monetizze.form',[
            'title_postfix'     => $monetizze->title,
            'navigation'        => $this->navigation,
            'data'              => $monetizze
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Marketing\Monetizze  $monetizze
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Monetizze $monetizze)
    {
        $request->validate([
            'title' => 'required',
            'link' => 'required',
            'updated_because' => 'required',
        ]);
        //Dados principais
        $monetizze->title = $request->title;
        $monetizze->active = $request->active;
        $monetizze->link = $request->link;
        $monetizze->description = $request->description;
        $monetizze->updated_because = $request->updated_because;
        $monetizze->updated_by = Auth::user()->name;

        //Imagem
        if(isset($request->image)){
            Storage::delete(['public/images/monetizzes/'.$monetizze->id.'.jpg', 'public/images/monetizzes/'.$monetizze->id.'.png','public/images/monetizzes/'.$monetizze->id.'.jpeg','public/images/monetizzes/'.$monetizze->id.'.webp']);
            $img= explode('.',$request->image);
            $extension = $img[1];
            $monetizze->image = $monetizze->id.'.'.$extension;
            /*Move as imagens do arquivo tmp para a pasta do arquivo */
            Storage::move('public/tmp/' . $request->image, 'public/images/monetizzes/'. $monetizze->image);
        }else{
            if(!isset($request->imageRemove)){
                Storage::delete(['public/images/monetizzes/'.$monetizze->id.'.jpg', 'public/images/monetizzes/'.$monetizze->id.'.png','public/images/monetizzes/'.$monetizze->id.'.jpeg','public/images/monetizzes/'.$monetizze->id.'.webp']);
                $monetizze->image = null;
            }
        }

        if($monetizze->save()){
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
     * @param  \App\Model\Marketing\Monetizze  $monetizze
     * @return \Illuminate\Http\Response
     */
    public function destroy(Monetizze $monetizze, Request $request)
    {
        $monetizze->active = '3';
        $monetizze->deleted_because = $request->motive;
        $monetizze->deleted_by = Auth::user()->name;
        $monetizze->deleted_at = date( 'Y-m-d H:i:s');

        if($monetizze->save()){
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
