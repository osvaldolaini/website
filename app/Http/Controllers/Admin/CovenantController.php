<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Model\Admin\Covenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CovenantController extends Controller
{
    //navegação
    private $navigation = array('title'=>'Convênios','link'=>'covenant.index');
    private $new_navigation = array('title'=>'Novo convênio ','link'=>'covenant.create');
    //textos para as mensagens e títulos
    private $configs = array(
        'new'                   => 'Novo convênio ',
        'msg-success-save'      => 'Convênios cadastrado com sucesso',
        'msg-error-save'        => 'Não foi possivel cadastrar o convênio',
        'msg-success-delete'    => 'Convênios excluido com sucesso',
        'msg-error-delete'      => 'Não foi possivel excluir o convênio',
        'msg-not-found'         => 'Convênios não encontrado',
        'location'              => 'convenios',
    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $covenants = Covenant::all();
        $data[]=array(null,null, null);
        if (isset($covenants)) {
            $data=array();
            foreach ($covenants as $covenant) {
                $buttons = Functions::buttons($covenant->id,10,$this->configs['location'],true);
                $data[]=array(
                    $covenant->title,
                    Functions::status($covenant->active),
                    $buttons,
                );
            }
        }

        return view('admin.covenants.listAll',[
            'title_postfix' => 'Convênios',
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
        return view('admin.covenants.form',[
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
            'title' => 'required|unique:covenants',
        ]);

        $covenant = new Covenant();
        //Dados principais
        $covenant->title    = $request->title;
        $covenant->active   = $request->active;
        $covenant->description = $request->description;
        $covenant->link = $request->link;
        $covenant->address = $request->address;
        $covenant->phone = $request->phone;
        $covenant->whatsapp = $request->whatsapp;
        $covenant->telegram = $request->telegram;
        $covenant->facebook = $request->facebook;
        $covenant->instagram = $request->instagram;
        $covenant->twitter = $request->twitter;
        $covenant->youtube = $request->youtube;
        $covenant->email = $request->email;

        $covenant->created_by = Auth::user()->name;

        if($covenant->save()){
            if(isset($request->image)){
                Storage::delete(['public/images/covenants/'.$covenant->id.'.jpg', 'public/images/covenants/'.$covenant->id.'.png','public/images/covenants/'.$covenant->id.'.jpeg','public/images/covenants/'.$covenant->id.'.webp']);
                $img= explode('.',$request->image);
                $extension = $img[1];
                $covenant->image = $covenant->id.'.'.$extension;
                $covenant->save();
                /*Move as imagens do arquivo tmp para a pasta do arquivo */
                Storage::move('public/tmp/' . $request->image, 'public/images/covenants/'. $covenant->image);
            }else{
                if(!isset($request->imageRemove)){
                    Storage::delete(['public/images/covenants/'.$covenant->id.'.jpg', 'public/images/covenants/'.$covenant->id.'.png','public/images/covenants/'.$covenant->id.'.jpeg','public/images/covenants/'.$covenant->id.'.webp']);
                    $covenant->image = null;
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
     * @param  \App\Model\Admin\Covenant  $covenant
     * @return \Illuminate\Http\Response
     */
    public function show(Covenant $covenant)
    {
        if($covenant){
            $data = array(
                'title' => $covenant->title,
                'body'  => array(
                    'Convêniado'        => $covenant->title,
                    'Visualizações'     => $covenant->clicks,
                    'Whatsapp'          => $covenant->whatsapp,
                    'Telegram'          => $covenant->telegram,
                    'Facebook'          => $covenant->facebook,
                    'Instagram'         => $covenant->instagram,
                    'Twitter'           => $covenant->twitter,
                    'Criado em'         => ($covenant->created_at ? date( 'd/m/Y H:i' , strtotime($covenant->created_at)) : ""),
                    'Criado por'        => $covenant->created_by,
                    'Atualizado em'     => ($covenant->updated_at ? date( 'd/m/Y H:i' , strtotime($covenant->updated_at)) : ""),
                    'Atualizado por'    => $covenant->updated_by,
                    'image'             => ($covenant->image ? url('storage/images/covenants/'.$covenant->image) : url('storage/images/logos/logo.png') ),
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
     * @param  \App\Model\Admin\Covenant  $covenant
     * @return \Illuminate\Http\Response
     */
    public function edit(Covenant $covenant)
    {
        return view('admin.covenants.form',[
            'title_postfix'     => $covenant->title,
            'navigation'        => $this->navigation,
            'data'              => $covenant
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Admin\Covenant  $covenant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Covenant $covenant)
    {
        $request->validate([
            'title' => 'required',
        ]);

        //Dados principais
        $covenant->title = $request->title;
        $covenant->active = $request->active;
        $covenant->description = $request->description;
        $covenant->link = $request->link;
        $covenant->address = $request->address;
        $covenant->phone = $request->phone;
        $covenant->whatsapp = $request->whatsapp;
        $covenant->telegram = $request->telegram;
        $covenant->facebook = $request->facebook;
        $covenant->instagram = $request->instagram;
        $covenant->twitter = $request->twitter;
        $covenant->youtube = $request->youtube;
        $covenant->email = $request->email;

        $covenant->updated_by = Auth::user()->name;
        $covenant->updated_because = $request->updated_because;

        if($covenant->save()){
            if(isset($request->image)){
                Storage::delete(['public/images/covenants/'.$covenant->id.'.jpg', 'public/images/covenants/'.$covenant->id.'.png','public/images/covenants/'.$covenant->id.'.jpeg','public/images/covenants/'.$covenant->id.'.webp']);
                $img= explode('.',$request->image);
                $extension = $img[1];
                $covenant->image = $covenant->id.'.'.$extension;
                $covenant->save();
                /*Move as imagens do arquivo tmp para a pasta do arquivo */
                Storage::move('public/tmp/' . $request->image, 'public/images/covenants/'. $covenant->image);
            }else{
                if(!isset($request->imageRemove)){
                    Storage::delete(['public/images/covenants/'.$covenant->id.'.jpg', 'public/images/covenants/'.$covenant->id.'.png','public/images/covenants/'.$covenant->id.'.jpeg','public/images/covenants/'.$covenant->id.'.webp']);
                    $covenant->image = null;
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Admin\Covenant  $covenant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Covenant $covenant)
    {
        $covenant->active = '3';
        $covenant->deleted_because = $request->motive;
        $covenant->deleted_by = Auth::user()->name;
        $covenant->deleted_at = date( 'Y-m-d H:i:s');

        if($covenant->save()){
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
