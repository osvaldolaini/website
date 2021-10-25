<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Model\Admin\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriberController extends Controller
{
    //navegação
    private $navigation = array('title'=>'Assinantes','link'=>'subscriber.index');
    private $new_navigation = array('title'=>'Novo assinante ','link'=>'subscriber.create');
    //textos para as mensagens e títulos
    private $configs = array(
        'new'                   => 'Novo assinante ',
        'msg-success-save'      => 'Assinatura cadastrada com sucesso',
        'msg-error-save'        => 'Não foi possivel cadastrar a assinatura',
        'msg-success-delete'    => 'Assinatura excluida com sucesso',
        'msg-error-delete'      => 'Não foi possivel excluir a assinatura',
        'msg-not-found'         => 'Assinatura não encontrada',
        'location'              => 'assinantes',
    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscribers = Subscriber::all();
        $data[]=array(null,null, null);
        if (isset($subscribers)) {
            $data=array();
            foreach ($subscribers as $subscriber) {
                $buttons = Functions::buttons($subscriber->id,10,$this->configs['location'],true);
                $data[]=array(
                    $subscriber->email,
                    Functions::status($subscriber->active),
                    $buttons,
                );
            }
        }

        return view('admin.subscribers.listAll',[
            'title_postfix' => 'Assinaturas',
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
        return view('admin.subscribers.form',[
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
            'email' => 'required|unique:subscribers',
        ]);

        $create = new Subscriber();
        //Dados principais
        $create->email = $request->email;
        $create->active = 1;
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
     * @param  \App\Model\Admin\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function show(Subscriber $subscriber)
    {
        if($subscriber){
            $data = array(
                'email' => $subscriber->email,
                'body'  => array(
                    'Email'         => $subscriber->email,
                    'Criado em'         => ($subscriber->created_at ? date( 'd/m/Y H:i' , strtotime($subscriber->created_at)) : ""),
                    'Criado por'        => $subscriber->created_by,
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
     * @param  \App\Model\Admin\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscriber $subscriber)
    {
        return view('admin.subscribers.form',[
            'title_postfix'     => $subscriber->email,
            'navigation'        => $this->navigation,
            'data'              => $subscriber
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Admin\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscriber $subscriber)
    {
        $request->validate([
            'email' => 'required',
        ]);

        //Dados principais
        $subscriber->email = $request->email;
        $subscriber->active = 1;
        $subscriber->created_by = Auth::user()->name;

        if($subscriber->save()){
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
     * @param  \App\Model\Admin\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Subscriber $subscriber)
    {
        $subscriber->active = '3';
        $subscriber->deleted_because = $request->motive;
        $subscriber->deleted_by = Auth::user()->name;
        $subscriber->deleted_at = date( 'Y-m-d H:i:s');

        if($subscriber->save()){
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
