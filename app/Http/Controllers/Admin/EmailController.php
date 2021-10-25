<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Model\Admin\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
     //navegação
     private $navigation = array('title'=>'Emails','link'=>'email.index');
     private $new_navigation = array('title'=>'Novo email ','link'=>'email.create');
     //textos para as mensagens e títulos
     private $configs = array(
         'new'                   => 'Novo email ',
         'msg-success-save'      => 'Email cadastrado com sucesso',
         'msg-error-save'        => 'Não foi possivel cadastrar o email',
         'msg-success-delete'    => 'Email excluido com sucesso',
         'msg-error-delete'      => 'Não foi possivel excluir o email',
         'msg-not-found'         => 'Email não encontrado',
         'location'              => 'emails',
     );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emails = Email::orderBy('active','asc')->orderBy('created_at','asc')->get();
        $data[]=array(null,null, null,null);
        if (isset($emails)) {
            $data=array();
            foreach ($emails as $email) {
                if($email->active==1){
                    $buttons = '<div class="btn btn-xs btn-success text-white mx-1 " data-trigger="hover" data-tooltip="tooltip" data-placement="top" title="Enviado" style="cursor:default"><i class="fas fa-lg fa-envelope"></i></div>';
                }else{
                    $buttons = Functions::buttons($email->id,10,$this->configs['location'],true);
                }

                $data[]=array(
                    $email->customer,
                    $email->subject,
                    Functions::status($email->active),
                    $buttons,
                );
            }
        }

        return view('admin.email.listAll',[
            'title_postfix' => 'Emails',
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
        return view('admin.email.form',[
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
            'message' => 'required',
            'from' => 'required',
            'customer' => 'required',
        ]);

        $create = new Email();
        //Dados principais
        $create->customer = $request->customer;
        $create->message = $request->message;
        $create->subject = $request->subject;
        $create->from = $request->from;
        $create->phone = $request->phone;
        $create->active = 0;
        $create->created_by = $request->customer;

        if($create->save()){
            return true;
            return response()->json(
                [
                    'success' => true,
                    'location'=> url($this->configs['location']),
                    'message' => $this->configs['msg-success-save']
                ]
            );
        }else{
            return false;
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
     * @param  \App\Model\Admin\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function show(Email $email)
    {
        if($email){
            $data = array(
                'title' => $email->title,
                'body'  => array(
                    'Mensagem'         => $email->message,
                    'Resposta'         => $email->answer,
                    'Criado em'         => ($email->created_at ? date( 'd/m/Y H:i' , strtotime($email->created_at)) : ""),
                    'Criado por'        => $email->created_by,
                    'Atualizado em'     => ($email->updated_at ? date( 'd/m/Y H:i' , strtotime($email->updated_at)) : ""),
                    'Atualizado por'    => $email->updated_by,
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
     * @param  \App\Model\Admin\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function edit(Email $email)
    {
        return view('admin.email.form',[
            'title_postfix'     => $email->customer,
            'navigation'        => $this->navigation,
            'data'              => $email
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Admin\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Email $email)
    {
        $request->validate([
            'answer' => 'required',
            'updated_because' => 'required',
            'subject' => 'required',
        ]);

        //Dados principais
        $email->answer = $request->answer;
        $email->subject = $request->subject;
        $email->updated_because = $request->updated_because;
        $email->updated_by = Auth::user()->name;

        if($email->save()){
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
     * @param  \App\Model\Admin\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Email $email)
    {
        $email->active = '3';
        $email->deleted_because = $request->motive;
        $email->deleted_by = Auth::user()->name;
        $email->deleted_at = date( 'Y-m-d H:i:s');

        if($email->save()){
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
    public function response(Request $request, Email $email)
    {
        $request->validate([
            'answer' => 'required',
        ]);

        //Dados principais
        $email->answer = $request->answer;
        $email->updated_because = $request->updated_because;
        $email->updated_by = Auth::user()->name;
        $email->send_at = date('Y-m-d h:i:s');
        $email->send_by = Auth::user()->name;
        $email->active = 1;

        if($email->save()){
            Mail::send(new \App\Mail\response($email));
            //return new \App\Mail\response($email);
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Email enviado com sucesso'
                ]
            );
        }else{
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Não foi possivel enviar o email'
                ]
            );
        }
    }
}
