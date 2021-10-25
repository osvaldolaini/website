<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Model\Admin\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformationController extends Controller
{
    //navegação
    private $navigation = array('title'=>'Informações','link'=>'information.index');
    private $new_navigation = array('title'=>'Nova informação ','link'=>'information.create');
    //textos para as mensagens e títulos
    private $configs = array(
        'new'                   => 'Nova informação ',
        'msg-success-save'      => 'Informação cadastrada com sucesso',
        'msg-error-save'        => 'Não foi possivel cadastrar a informação',
        'msg-success-delete'    => 'Informação excluida com sucesso',
        'msg-error-delete'      => 'Não foi possivel excluir a informação',
        'msg-not-found'         => 'Informação não encontrada',
        'location'              => 'informacoes',
    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $informations = Information::all();
        $data[]=array(null,null, null);
        if (isset($informations)) {
            $data=array();
            foreach ($informations as $information) {
                $buttons = Functions::buttons($information->id,10,$this->configs['location'],true);
                $data[]=array(
                    $information->title,
                    Functions::status($information->active),
                    $buttons,
                );
            }
        }

        return view('admin.informations.listAll',[
            'title_postfix' => 'Avisos',
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
        return view('admin.informations.form',[
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
            'title' => 'required|unique:information',
        ]);

        $create = new Information();
        //Dados principais
        $create->title = $request->title;
        $create->active = $request->active;
        $create->description = $request->description;
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
     * @param  \App\Model\Admin\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function show(Information $information)
    {
        if($information){
            $data = array(
                'title' => $information->title,
                'body'  => array(
                    'Título'            => $information->title,
                    'Visualizações'     => $information->clicks,
                    'Criado em'         => ($information->created_at ? date( 'd/m/Y H:i' , strtotime($information->created_at)) : ""),
                    'Criado por'        => $information->created_by,
                    'Atualizado em'     => ($information->updated_at ? date( 'd/m/Y H:i' , strtotime($information->updated_at)) : ""),
                    'Atualizado por'    => $information->updated_by,
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
     * @param  \App\Model\Admin\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function edit(Information $information)
    {
        return view('admin.informations.form',[
            'title_postfix'     => $information->title,
            'navigation'        => $this->navigation,
            'data'              => $information
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Admin\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Information $information)
    {
        $request->validate([
            'title' => 'required',
            'updated_because' => 'required',
        ]);

        //Dados principais
        $information->title = $request->title;
        $information->active = $request->active;
        $information->description = $request->description;
        $information->updated_by = Auth::user()->name;
        $information->updated_because = $request->updated_because;

        if($information->save()){
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
     * @param  \App\Model\Admin\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Information $information)
    {
        $information->active = '3';
        $information->deleted_because = $request->motive;
        $information->deleted_by = Auth::user()->name;
        $information->deleted_at = date( 'Y-m-d H:i:s');

        if($information->save()){
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
