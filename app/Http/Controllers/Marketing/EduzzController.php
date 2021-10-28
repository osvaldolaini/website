<?php

namespace App\Http\Controllers\Marketing;

use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Model\Marketing\Eduzz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EduzzController extends Controller
{
   //navegação
   private $navigation = array('title'=>'Eduzz afiliações','link'=>'eduzz.index');
   private $new_navigation = array('title'=>'Nova afiliação ','link'=>'eduzz.create');
   //textos para as mensagens e títulos
   private $configs = array(
       'new'                   => 'Nova afiliação ',
       'msg-success-save'      => 'Afiliação cadastrada com sucesso',
       'msg-error-save'        => 'Não foi possivel cadastrar a afiliação',
       'msg-success-delete'    => 'Afiliação excluida com sucesso',
       'msg-error-delete'      => 'Não foi possivel excluir a afiliação',
       'msg-not-found'         => 'Afiliação não encontrada',
       'location'              => 'afiliacoes-eduzz',
   );
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $query = Eduzz::all();
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

        return view('marketing.eduzz.listAll',[
            'title_postfix' => 'Afiliações Eduzz',
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
        return view('marketing.eduzz.form',[
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
            'title' => 'required|unique:eduzzs',
            'link' => 'required|unique:eduzzs',
        ]);

        $create = new Eduzz();
        //Dados principais
        $create->title = $request->title;
        $create->active = $request->active;
        $create->link = $request->link;
        $create->description = $request->description;
        $create->path = 'storage/images/eduzzs/';
        $create->created_by = Auth::user()->name;

        if($create->save()){
            if(isset($request->image)){
                Storage::delete(['public/images/eduzzs/'.$create->id.'.jpg', 'public/images/eduzzs/'.$create->id.'.png','public/images/eduzzs/'.$create->id.'.jpeg','public/images/eduzzs/'.$create->id.'.webp']);
                $img= explode('.',$request->image);
                $extension = $img[1];
                $create->image = $create->id.'.'.$extension;
                $create->save();
                /*Move as imagens do arquivo tmp para a pasta do arquivo */
                Storage::move('public/tmp/' . $request->image, 'public/images/eduzzs/'. $create->image);
            }else{
                if(!isset($request->imageRemove)){
                    Storage::delete(['public/images/eduzzs/'.$create->id.'.jpg', 'public/images/eduzzs/'.$create->id.'.png','public/images/eduzzs/'.$create->id.'.jpeg','public/images/eduzzs/'.$create->id.'.webp']);
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
     * @param  \App\Model\Marketing\Eduzz  $eduzz
     * @return \Illuminate\Http\Response
     */
    public function show(Eduzz $eduzz)
    {
        if($eduzz){
            $data = array(
                'title' => $eduzz->title,
                'body'  => array(
                    'Afiliação'         => $eduzz->title,
                    'Cliques'           => $eduzz->clicks,
                    'Criado em'         => ($eduzz->created_at ? date( 'd/m/Y H:i' , strtotime($eduzz->created_at)) : ""),
                    'Criado por'        => $eduzz->created_by,
                    'Atualizado em'     => ($eduzz->updated_at ? date( 'd/m/Y H:i' , strtotime($eduzz->updated_at)) : ""),
                    'Atualizado por'    => $eduzz->updated_by,
                    'image'             => ($eduzz->image ? url('storage/images/eduzzs/'.$eduzz->image) : url('storage/images/logos/logo.png') ),
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
     * @param  \App\Model\Marketing\Eduzz  $eduzz
     * @return \Illuminate\Http\Response
     */
    public function edit(Eduzz $eduzz)
    {
        return view('marketing.eduzz.form',[
            'title_postfix'     => $eduzz->title,
            'navigation'        => $this->navigation,
            'data'              => $eduzz
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Marketing\Eduzz  $eduzz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Eduzz $eduzz)
    {
        $request->validate([
            'title' => 'required',
            'link' => 'required',
            'updated_because' => 'required',
        ]);
        //Dados principais
        $eduzz->title = $request->title;
        $eduzz->active = $request->active;
        $eduzz->link = $request->link;
        $eduzz->description = $request->description;
        $eduzz->updated_because = $request->updated_because;
        $eduzz->updated_by = Auth::user()->name;

        //Imagem
        if(isset($request->image)){
            Storage::delete(['public/images/eduzzs/'.$eduzz->id.'.jpg', 'public/images/eduzzs/'.$eduzz->id.'.png','public/images/eduzzs/'.$eduzz->id.'.jpeg','public/images/eduzzs/'.$eduzz->id.'.webp']);
            $img= explode('.',$request->image);
            $extension = $img[1];
            $eduzz->image = $eduzz->id.'.'.$extension;
            /*Move as imagens do arquivo tmp para a pasta do arquivo */
            Storage::move('public/tmp/' . $request->image, 'public/images/eduzzs/'. $eduzz->image);
        }else{
            if(!isset($request->imageRemove)){
                Storage::delete(['public/images/eduzzs/'.$eduzz->id.'.jpg', 'public/images/eduzzs/'.$eduzz->id.'.png','public/images/eduzzs/'.$eduzz->id.'.jpeg','public/images/eduzzs/'.$eduzz->id.'.webp']);
                $eduzz->image = null;
            }
        }

        if($eduzz->save()){
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
     * @param  \App\Model\Marketing\Eduzz  $eduzz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Eduzz $eduzz, Request $request)
    {
        $eduzz->active = '3';
        $eduzz->deleted_because = $request->motive;
        $eduzz->deleted_by = Auth::user()->name;
        $eduzz->deleted_at = date( 'Y-m-d H:i:s');

        if($eduzz->save()){
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
