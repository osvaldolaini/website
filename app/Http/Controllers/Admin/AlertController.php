<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Model\Admin\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlertController extends Controller
{
    //navegação
    private $navigation = array('title'=>'Avisos','link'=>'alert.index');
    private $new_navigation = array('title'=>'Novo aviso ','link'=>'alert.create');
    //textos para as mensagens e títulos
    private $configs = array(
        'new'                   => 'Novo aviso ',
        'msg-success-save'      => 'Aviso cadastrado com sucesso',
        'msg-error-save'        => 'Não foi possivel cadastrar o aviso',
        'msg-success-delete'    => 'Aviso excluido com sucesso',
        'msg-error-delete'      => 'Não foi possivel excluir o aviso',
        'msg-not-found'         => 'Aviso não encontrado',
        'location'              => 'avisos',
    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alerts = Alert::all();
        $data[]=array(null,null, null);
        if (isset($alerts)) {
            $data=array();
            foreach ($alerts as $alert) {
                $buttons = Functions::buttons($alert->id,10,$this->configs['location'],true);
                $data[]=array(
                    $alert->title,
                    Functions::status($alert->active),
                    $buttons,
                );
            }
        }

        return view('admin.alerts.listAll',[
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
        return view('admin.alerts.form',[
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
            'title' => 'required|unique:alerts',
        ]);

        $create = new Alert();
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
     * @param  \App\Model\Admin\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function show(Alert $alert)
    {
        if($alert){
            $data = array(
                'title' => $alert->title,
                'body'  => array(
                    'Título'            => $alert->title,
                    'Visualizações'     => $alert->clicks,
                    'Criado em'         => ($alert->created_at ? date( 'd/m/Y H:i' , strtotime($alert->created_at)) : ""),
                    'Criado por'        => $alert->created_by,
                    'Atualizado em'     => ($alert->updated_at ? date( 'd/m/Y H:i' , strtotime($alert->updated_at)) : ""),
                    'Atualizado por'    => $alert->updated_by,
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
     * @param  \App\Model\Admin\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function edit(Alert $alert)
    {
        return view('admin.alerts.form',[
            'title_postfix'     => $alert->title,
            'navigation'        => $this->navigation,
            'data'              => $alert
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Admin\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alert $alert)
    {
        $request->validate([
            'title' => 'required',
            'updated_because' => 'required',
        ]);

        //Dados principais
        $alert->title = $request->title;
        $alert->active = $request->active;
        $alert->description = $request->description;
        $alert->updated_by = Auth::user()->name;
        $alert->updated_because = $request->updated_because;

        if($alert->save()){
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
     * @param  \App\Model\Admin\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Alert $alert)
    {
        $alert->active = '3';
        $alert->deleted_because = $request->motive;
        $alert->deleted_by = Auth::user()->name;
        $alert->deleted_at = date( 'Y-m-d H:i:s');

        if($alert->save()){
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
