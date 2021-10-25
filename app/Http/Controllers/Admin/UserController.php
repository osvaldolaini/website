<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Model\Admin\UserGroups;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //navegação
    private $navigation = array('title'=>'Lista de usuários','link'=>'user.index');
    //textos para as mensagens e títulos
    private $configs = array(
        'new'                   => 'Novo usuário ',
        'msg-success-save'      => 'Dados do usuário cadastrados com sucesso',
        'msg-error-save'        => 'Não foi possivel cadastrar o usuário',
        'msg-success-delete'    => 'Dados do usuário excluidos com sucesso',
        'msg-error-delete'      => 'Não foi possivel excluir o usuário',
        'msg-not-found'         => 'Usuário não encontrado',
        'location'              => 'usuarios',
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->group->id <= 1){
            $users = User::all();
        }else{
            $users = User::where('group_id', '>', 1)->get();
        }

        if (isset($users)) {
            foreach ($users as $user) {
                $btnEdit = '<a href="usuarios/'.$user->id.'/editar" class="btn btn-xs btn-secondary text-white mx-1 shadow" data-trigger="hover" data-toggle="tooltip" data-placement="bottom" title="Editar">
                <i class="fa fa-lg fa-fw fa-pen"></i></a>';
                $btnDelete = '<a href="#" data-id="'.$user->id.'" class="btn btn-xs btn-danger text-white mx-1 shadow delete" title="Apagar">
                <i class="fa fa-lg fa-fw fa-trash"></i></a>';
                $btnDetails = '<a data-id="'.$user->id.'" class="btn btn-xs btn-primary text-white mx-1 shadow viewModel" title="Ver">
                <i class="fa fa-lg fa-fw fa-eye"></i></a>';
                $data[]=array(
                    $user->name,$user->email,$user->group->title,'<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>',
                );
            }
        }else{
            $data[]='';
        }

        return view('admin.users.listAll',[
            'title_postfix'  =>  'Usuários',
            'new'           => $this->configs['new'],
            'data'          => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->group->id <= 1){
            $groups = UserGroups::all();
        }else{
            $groups = UserGroups::where('id', '>', 1)->get();
        }
        return view('admin.users.form',[
            'title_postfix'     => $this->configs['new'],
            'navigation'        => $this->navigation,
            'groups'            => $groups
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
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->group_id = $request->group_id;
        $user->active = $request->active;
        $user->created_by = Auth::user()->name;
        $user->password = Hash::make($request->password);

        if($user->save()){
            if(isset($request->image)){
                Storage::delete(['public/images/users/'.$user->id.'.jpg', 'public/images/users/'.$user->id.'.png','public/images/users/'.$user->id.'.jpeg','public/images/users/'.$user->id.'.webp']);
                $img= explode('.',$request->image);
                $extension = $img[1];
                $user->image = $user->id.'.'.$extension;
                $user->save();
                /*Move as imagens do arquivo tmp para a pasta do arquivo */
                Storage::move('public/tmp/' . $request->image, 'public/images/users/'. $user->image);
            }else{
                if(!isset($request->imageRemove)){
                    Storage::delete(['public/images/users/'.$user->id.'.jpg', 'public/images/users/'.$user->id.'.png','public/images/users/'.$user->id.'.jpeg','public/images/users/'.$user->id.'.webp']);
                    $user->image = null;
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
     * @param  \App\Admin\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if($user){
            $data = array(
                'title' => $user->name,
                'body'  => $body=array(
                    'Nome'              => $user->name,
                    'Email'             => $user->email,
                    'Nível de acesso'   => $user->group->title,
                    'Cadastrado em'     => ($user->created_at ? date( 'd/m/Y H:i' , strtotime($user->created_at)) : ""),
                    'image'             => ($user->image ? url('storage/images/users/'.$user->image) : url('storage/images/logos/logo.png') ),
                )
            );
            return response()->json(
                [
                    'success' => true,
                    'user' => $data
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
     * @param  \App\Admin\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if(Auth::user()->group->id <= 1){
            $groups = UserGroups::all();
        }else{
            $groups = UserGroups::where('id', '>', 1)->get();
        }
        return view('admin.users.form',[
            'user'          => $user,
            'title_postfix' => $user->name,
            'navigation'    => $this->navigation,
            'groups'        => $groups
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if(filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            $user->email = $request->email;
        }

        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->active = $request->active;
        $user->name = $request->name;
        $user->group_id = $request->group_id;
        $user->updated_by = Auth::user()->name;

        if(isset($request->image)){
            Storage::delete(['public/images/users/'.$user->id.'.jpg', 'public/images/users/'.$user->id.'.png','public/images/users/'.$user->id.'.jpeg','public/images/users/'.$user->id.'.webp']);
            $img= explode('.',$request->image);
            $extension = $img[1];
            $user->image = $user->id.'.'.$extension;
            /*Move as imagens do arquivo tmp para a pasta do arquivo */
            Storage::move('public/tmp/' . $request->image, 'public/images/users/'. $user->image);
        }else{
            if(!isset($request->imageRemove)){
                Storage::delete(['public/images/users/'.$user->id.'.jpg', 'public/images/users/'.$user->id.'.png','public/images/users/'.$user->id.'.jpeg','public/images/users/'.$user->id.'.webp']);
                $user->image = null;
            }
        }

        if($user->save()){
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
     * @param  \App\Admin\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->delete()){
            /*Exclui as imagens da pasta */
            Storage::delete('images/users/'.$user->image);
            return response()->json(
                [
                    'success'   => true,
                    'location'  => url('usuarios'),
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
