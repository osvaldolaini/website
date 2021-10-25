<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Model\Admin\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
       //navegação
       private $navigation = array('title'=>'Parceiros','link'=>'partner.index');
       private $new_navigation = array('title'=>'Novo parceiro ','link'=>'partner.create');
       //textos para as mensagens e títulos
       private $configs = array(
           'new'                   => 'Novo parceiro ',
           'msg-success-save'      => 'Parceiro cadastrado com sucesso',
           'msg-error-save'        => 'Não foi possivel cadastrar o parceiro',
           'msg-success-delete'    => 'Parceiro excluido com sucesso',
           'msg-error-delete'      => 'Não foi possivel excluir o parceiro',
           'msg-not-found'         => 'Parceiro não encontrado',
           'location'              => 'parceiros',
       );
       /**
        * Display a listing of the resource.
        *
        * @return \Illuminate\Http\Response
        */
       public function index()
       {
           $partners = Partner::all();
           $data[]=array(null,null, null);
           if (isset($partners)) {
               $data=array();
               foreach ($partners as $partner) {
                   $buttons = Functions::buttons($partner->id,10,$this->configs['location'],true);
                   $data[]=array(
                       $partner->title,
                       Functions::status($partner->active),
                       $buttons,
                   );
               }
           }

           return view('admin.partners.listAll',[
               'title_postfix' => 'Parceiros',
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
        return view('admin.partners.form',[
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
            'title' => 'required|unique:partners',
            'link' => 'required|unique:partners',
        ]);

        $partner = new Partner();
        //Dados principais
        $partner->title = $request->title;
        $partner->active = $request->active;
        $partner->link = $request->link;
        $partner->phone = $request->phone;
        $partner->whatsapp = $request->whatsapp;
        $partner->telegram = $request->telegram;
        $partner->facebook = $request->facebook;
        $partner->instagram = $request->instagram;
        $partner->twitter = $request->twitter;
        $partner->youtube = $request->youtube;
        $partner->email = $request->email;

        $partner->created_by = Auth::user()->name;

        if($partner->save()){
            if(isset($request->image)){
                Storage::delete(['public/images/partners/'.$partner->id.'.jpg', 'public/images/partners/'.$partner->id.'.png','public/images/partners/'.$partner->id.'.jpeg','public/images/partners/'.$partner->id.'.webp']);
                $img= explode('.',$request->image);
                $extension = $img[1];
                $partner->image = $partner->id.'.'.$extension;
                $partner->save();
                /*Move as imagens do arquivo tmp para a pasta do arquivo */
                Storage::move('public/tmp/' . $request->image, 'public/images/partners/'. $partner->image);
            }else{
                if(!isset($request->imageRemove)){
                    Storage::delete(['public/images/partners/'.$partner->id.'.jpg', 'public/images/partners/'.$partner->id.'.png','public/images/partners/'.$partner->id.'.jpeg','public/images/partners/'.$partner->id.'.webp']);
                    $partner->image = null;
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
     * @param  \App\Model\Admin\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        if($partner){
            $data = array(
                'title' => $partner->title,
                'body'  => array(
                    'Empresa / Cliente' => $partner->title,
                    'Whatsapp' => $partner->whatsapp,
                    'Telegram' => $partner->telegram,
                    'Facebook' => $partner->facebook,
                    'Instagram' => $partner->instagram,
                    'Twitter' => $partner->twitter,
                    'Criado em'         => ($partner->created_at ? date( 'd/m/Y H:i' , strtotime($partner->created_at)) : ""),
                    'Criado por'        => $partner->created_by,
                    'Atualizado em'     => ($partner->updated_at ? date( 'd/m/Y H:i' , strtotime($partner->updated_at)) : ""),
                    'Atualizado por'    => $partner->updated_by,
                    'image'             => ($partner->image ? url('storage/images/partners/'.$partner->image) : url('storage/images/logos/logo.png') ),
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
     * @param  \App\Model\Admin\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner)
    {
        return view('admin.partners.form',[
            'title_postfix'     =>  $partner->title,
            'navigation'        => $this->navigation,
            'data'              => $partner
        ]);
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
        $request->validate([
            'title' => 'required',
            'link' => 'required',
            'updated_because' => 'required',
        ]);

        //Dados principais
        $partner->title = $request->title;
        $partner->active = $request->active;
        $partner->link = $request->link;
        $partner->phone = $request->phone;
        $partner->whatsapp = $request->whatsapp;
        $partner->telegram = $request->telegram;
        $partner->facebook = $request->facebook;
        $partner->instagram = $request->instagram;
        $partner->twitter = $request->twitter;
        $partner->youtube = $request->youtube;
        $partner->email = $request->email;
        $partner->updated_because = $request->updated_because;

        $partner->updated_by = Auth::user()->name;

        if($partner->save()){
            if(isset($request->image)){
                Storage::delete(['public/images/partners/'.$partner->id.'.jpg', 'public/images/partners/'.$partner->id.'.png','public/images/partners/'.$partner->id.'.jpeg','public/images/partners/'.$partner->id.'.webp']);
                $img= explode('.',$request->image);
                $extension = $img[1];
                $partner->image = $partner->id.'.'.$extension;
                $partner->save();
                /*Move as imagens do arquivo tmp para a pasta do arquivo */
                Storage::move('public/tmp/' . $request->image, 'public/images/partners/'. $partner->image);
            }else{
                if(!isset($request->imageRemove)){
                    Storage::delete(['public/images/partners/'.$partner->id.'.jpg', 'public/images/partners/'.$partner->id.'.png','public/images/partners/'.$partner->id.'.jpeg','public/images/partners/'.$partner->id.'.webp']);
                    $partner->image = null;
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
     * @param  \App\Model\Admin\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Partner $partner)
    {
        $partner->active = '3';
        $partner->deleted_because = $request->motive;
        $partner->deleted_by = Auth::user()->name;
        $partner->deleted_at = date( 'Y-m-d H:i:s');

        if($partner->save()){
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
