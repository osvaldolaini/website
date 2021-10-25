<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Model\Admin\Sport;
use App\Model\Admin\SportImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SportController extends Controller
{
    //navegação
    private $navigation = array('title'=>'Esportes','link'=>'sport.index');
    private $new_navigation = array('title'=>'Novo esporte ','link'=>'sport.create');
    //textos para as mensagens e títulos
    private $configs = array(
        'new'                   => 'Novo esporte ',
        'msg-success-save'      => 'Esporte cadastrado com sucesso',
        'msg-error-save'        => 'Não foi possivel cadastrar o esporte',
        'msg-success-delete'    => 'Esporte excluido com sucesso',
        'msg-error-delete'      => 'Não foi possivel excluir o esporte',
        'msg-not-found'         => 'Esporte não encontrado',
        'location'              => 'esportes',
    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sports = Sport::all();
        $data[]=array(null,null, null,null);
        if (isset($sports)) {
            $data=array();
            foreach ($sports as $sport) {
                $buttons = Functions::buttons($sport->id,10,$this->configs['location'],true);
                $data[]=array(
                    $sport->title,
                    mb_strtoupper($sport->responsible),
                    Functions::status($sport->active),
                    $buttons,
                );
            }
        }

        return view('admin.sports.listAll',[
            'title_postfix' => 'Esporte',
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
        return view('admin.sports.form',[
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
            'title' => 'required|unique:sports',
            'responsible' => 'required',
        ]);

        $sport = new Sport();
        //Dados principais
        $sport->title = $request->title;
        $sport->active = $request->active;
        $sport->link = $request->link;
        $sport->description = $request->description;
        $sport->responsible = $request->responsible;
        $sport->phone = $request->phone;
        $sport->whatsapp = $request->whatsapp;
        $sport->telegram = $request->telegram;
        $sport->facebook = $request->facebook;
        $sport->instagram = $request->instagram;
        $sport->twitter = $request->twitter;
        $sport->youtube = $request->youtube;
        $sport->email = $request->email;

        $sport->created_by = Auth::user()->name;

        if($sport->save()){
            $images = $request->images;
            if(isset($images)){
                for ($i=0; $i < count($images); $i++) {
                    $img= explode('.',$images[$i]);
                    $extension = $img[1];
                    $new_name = $sport->slug.'-'.$i.'.'.$extension;
                    /*Move as imagens do arquivo tmp para a pasta do arquivo */
                    Storage::move('public/tmp/' . $images[$i], 'public/images/sports/'.$sport->id.'/'.$new_name);
                    /*Cadastra as imagens no banco de dados */

                    $sportImage = new SportImage();
                    $sportImage->title=$new_name;
                    $sportImage->featured=$request->featured[$i];
                    $sportImage->sport_id=$sport->id;
                    $sportImage->path='images/sports/'.$sport->id.'/';
                    $sportImage->save();
                    unset($sportImage);
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
     * @param  \App\Model\Admin\Sport  $sport
     * @return \Illuminate\Http\Response
     */
    public function show(Sport $sport)
    {
        if($sport){

            $image = $sport->images()->where('featured',1)->first();
            $data = array(
                'title' => $sport->title,
                'body'  => array(
                    'Modalidade'        => $sport->title,
                    'Visualizações'     => $sport->clicks,
                    'Whatsapp'          => $sport->whatsapp,
                    'Telegram'          => $sport->telegram,
                    'Facebook'          => $sport->facebook,
                    'Instagram'         => $sport->instagram,
                    'Twitter'           => $sport->twitter,
                    'Criado em'         => ($sport->created_at ? date( 'd/m/Y H:i' , strtotime($sport->created_at)) : ""),
                    'Criado por'        => $sport->created_by,
                    'Atualizado em'     => ($sport->updated_at ? date( 'd/m/Y H:i' , strtotime($sport->updated_at)) : ""),
                    'Atualizado por'    => $sport->updated_by,
                    'image'            => ($image ? url('storage/images/sports/'.$sport->id.'/'.$image->title) : url('storage/images/logos/logo.png') )

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
     * @param  \App\Model\Admin\Sport  $sport
     * @return \Illuminate\Http\Response
     */
    public function edit(Sport $sport)
    {
        $images = $sport->images()->get();
        return view('admin.sports.form',[
            'title_postfix'     => $sport->title,
            'navigation'        => $this->navigation,
            'data'              => $sport,
            'images'            => $images,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Admin\Sport  $sport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sport $sport)
    {
        $request->validate([
            'title' => 'required',
            'responsible' => 'required',
            'updated_because' => 'required',
        ]);

        //Dados principais
        $sport->title = $request->title;
        $sport->active = $request->active;
        $sport->link = $request->link;
        $sport->description = $request->description;
        $sport->responsible = $request->responsible;
        $sport->phone = $request->phone;
        $sport->whatsapp = $request->whatsapp;
        $sport->telegram = $request->telegram;
        $sport->facebook = $request->facebook;
        $sport->instagram = $request->instagram;
        $sport->twitter = $request->twitter;
        $sport->youtube = $request->youtube;
        $sport->email = $request->email;

        $sport->updated_because = $request->updated_because;
        $sport->updated_by = Auth::user()->name;

            /*Pega as imagens que não foram excluidas na pasta */
            $files = Storage::allFiles('public/images/sports/'.$sport->id);
            if(isset($files)){
                for ($i=0; $i < count($files); $i++) {
                    /*Pega nome da imagem */
                    $name = explode('/',$files[$i]);
                    $image_name = $name[4];
                    /*Move as imagens para o arquivo temporário */
                    Storage::move($files[$i], 'public/tmp/' . $image_name);
                }
                /*Limpa a pasta do arquivo */
                Storage::deleteDirectory('public/images/sports/'.$sport->id);
            }

        if($sport->save()){
            DB::table('sport_images')->where('sport_id', $sport->id)->delete();
            $images = $request->images;
            if(isset($images)){
                for ($i=0; $i < count($images); $i++) {
                    $img= explode('.',$images[$i]);
                    $extension = $img[1];
                    $new_name = $sport->slug.'-'.$i.'.'.$extension;
                    /*Move as imagens do arquivo tmp para a pasta do arquivo */
                    Storage::move('public/tmp/' . $images[$i], 'public/images/sports/'.$sport->id.'/'.$new_name);
                    /*Cadastra as imagens no banco de dados */

                    $sportImage = new sportImage();
                    $sportImage->title=$new_name;
                    $sportImage->featured=$request->featured[$i];
                    $sportImage->sport_id=$sport->id;
                    $sportImage->path='images/sports/'.$sport->id.'/';
                    $sportImage->save();
                    unset($sportImage);
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
     * @param  \App\Model\Admin\Sport  $sport
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Sport $sport)
    {
        $sport->active = '3';
        $sport->deleted_because = $request->motive;
        $sport->deleted_by = Auth::user()->name;
        $sport->deleted_at = date( 'Y-m-d H:i:s');

        if($sport->save()){
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
