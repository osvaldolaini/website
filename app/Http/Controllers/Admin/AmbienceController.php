<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Model\Admin\Ambience;
use App\Model\Admin\AmbienceImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AmbienceController extends Controller
{
    //navegação
    private $navigation = array('title'=>'Ambientes','link'=>'ambience.index');
    private $new_navigation = array('title'=>'Novo ambiente ','link'=>'ambience.create');
    //textos para as mensagens e títulos
    private $configs = array(
        'new'                   => 'Novo ambiente ',
        'msg-success-save'      => 'Ambiente cadastrado com sucesso',
        'msg-error-save'        => 'Não foi possivel cadastrar o ambiente',
        'msg-success-delete'    => 'Ambiente excluido com sucesso',
        'msg-error-delete'      => 'Não foi possivel excluir o ambiente',
        'msg-not-found'         => 'Ambiente não encontrado',
        'location'              => 'ambientes',
    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ambiences = Ambience::all();
        $data[]=array(null,null, null);
        if (isset($ambiences)) {
            $data=array();
            foreach ($ambiences as $ambience) {
                $buttons = Functions::buttons($ambience->id,10,$this->configs['location'],true);
                $data[]=array(
                    $ambience->title,
                    Functions::status($ambience->active),
                    $buttons,
                );
            }
        }

        return view('admin.ambiences.listAll',[
            'title_postfix' => 'Ambientes',
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
        return view('admin.ambiences.form',[
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
            'title' => 'required|unique:ambiences',
        ]);

        $ambience = new Ambience();
        //Dados principais
        $ambience->title = $request->title;
        $ambience->active = $request->active;
        $ambience->description = $request->description;

        $ambience->created_by = Auth::user()->name;

        if($ambience->save()){
            $images = $request->images;
            if(isset($images)){
                for ($i=0; $i < count($images); $i++) {
                    $img= explode('.',$images[$i]);
                    $extension = $img[1];
                    $new_name = $ambience->slug.'-'.$i.'.'.$extension;
                    /*Move as imagens do arquivo tmp para a pasta do arquivo */
                    Storage::move('public/tmp/' . $images[$i], 'public/images/ambiences/'.$ambience->id.'/'.$new_name);
                    /*Cadastra as imagens no banco de dados */

                    $ambienceImage = new AmbienceImage();
                    $ambienceImage->title=$new_name;
                    $ambienceImage->featured=$request->featured[$i];
                    $ambienceImage->ambience_id=$ambience->id;
                    $ambienceImage->path='images/ambiences/'.$ambience->id.'/';
                    $ambienceImage->save();
                    unset($ambienceImage);
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
     * @param  \App\Model\Admin\Ambience  $ambience
     * @return \Illuminate\Http\Response
     */
    public function show(Ambience $ambience)
    {
        if($ambience){

            $image = $ambience->images()->where('featured',1)->first();
            $data = array(
                'title' => $ambience->title,
                'body'  => array(
                    'Modalidade'        => $ambience->title,
                    'Visualizações'     => $ambience->clicks,
                    'Criado em'         => ($ambience->created_at ? date( 'd/m/Y H:i' , strtotime($ambience->created_at)) : ""),
                    'Criado por'        => $ambience->created_by,
                    'Atualizado em'     => ($ambience->updated_at ? date( 'd/m/Y H:i' , strtotime($ambience->updated_at)) : ""),
                    'Atualizado por'    => $ambience->updated_by,
                    'image'            => ($image ? url('storage/images/ambiences/'.$ambience->id.'/'.$image->title) : url('storage/images/logos/logo.png') )

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
     * @param  \App\Model\Admin\Ambience  $ambience
     * @return \Illuminate\Http\Response
     */
    public function edit(Ambience $ambience)
    {
        $images = $ambience->images()->get();
        return view('admin.ambiences.form',[
            'title_postfix'     => $ambience->title,
            'navigation'        => $this->navigation,
            'data'              => $ambience,
            'images'            => $images,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Admin\Ambience  $ambience
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ambience $ambience)
    {
        $request->validate([
            'title' => 'required',
            'updated_because' => 'required',
        ]);

        //Dados principais
        $ambience->title = $request->title;
        $ambience->active = $request->active;
        $ambience->description = $request->description;

        $ambience->updated_because = $request->updated_because;
        $ambience->updated_by = Auth::user()->name;

            /*Pega as imagens que não foram excluidas na pasta */
            $files = Storage::allFiles('public/images/ambiences/'.$ambience->id);
            if(isset($files)){
                for ($i=0; $i < count($files); $i++) {
                    /*Pega nome da imagem */
                    $name = explode('/',$files[$i]);
                    $image_name = $name[4];
                    /*Move as imagens para o arquivo temporário */
                    Storage::move($files[$i], 'public/tmp/' . $image_name);
                }
                /*Limpa a pasta do arquivo */
                Storage::deleteDirectory('public/images/ambiences/'.$ambience->id);
            }

        if($ambience->save()){
            DB::table('ambience_images')->where('ambience_id', $ambience->id)->delete();
            $images = $request->images;
            if(isset($images)){
                for ($i=0; $i < count($images); $i++) {
                    $img= explode('.',$images[$i]);
                    $extension = $img[1];
                    $new_name = $ambience->slug.'-'.$i.'.'.$extension;
                    /*Move as imagens do arquivo tmp para a pasta do arquivo */
                    Storage::move('public/tmp/' . $images[$i], 'public/images/ambiences/'.$ambience->id.'/'.$new_name);
                    /*Cadastra as imagens no banco de dados */

                    $ambienceImage = new ambienceImage();
                    $ambienceImage->title=$new_name;
                    $ambienceImage->featured=$request->featured[$i];
                    $ambienceImage->ambience_id=$ambience->id;
                    $ambienceImage->path='images/ambiences/'.$ambience->id.'/';
                    $ambienceImage->save();
                    unset($ambienceImage);
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
     * @param  \App\Model\Admin\Ambience  $ambience
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Ambience $ambience)
    {
        $ambience->active = '3';
        $ambience->deleted_because = $request->motive;
        $ambience->deleted_by = Auth::user()->name;
        $ambience->deleted_at = date( 'Y-m-d H:i:s');

        if($ambience->save()){
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
