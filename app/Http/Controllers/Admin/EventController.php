<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Model\Admin\Event;
use App\Model\Admin\EventImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    //navegação
    private $navigation = array('title'=>'Eventos','link'=>'event.index');
    private $new_navigation = array('title'=>'Novo evento ','link'=>'event.create');
    //textos para as mensagens e títulos
    private $configs = array(
        'new'                   => 'Novo evento ',
        'msg-success-save'      => 'Evento cadastrado com sucesso',
        'msg-error-save'        => 'Não foi possivel cadastrar o evento',
        'msg-success-delete'    => 'Evento excluido com sucesso',
        'msg-error-delete'      => 'Não foi possivel excluir o evento',
        'msg-not-found'         => 'Evento não encontrado',
        'location'              => 'eventos',
    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();
        $data[]=array(null,null, null);
        if (isset($events)) {
            $data=array();
            foreach ($events as $event) {
                $buttons = Functions::buttons($event->id,10,$this->configs['location'],true);
                $data[]=array(
                    $event->title,
                    Functions::status($event->active),
                    $buttons,
                );
            }
        }

        return view('admin.events.listAll',[
            'title_postfix' => 'Notícias',
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
        return view('admin.events.form',[
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
            'title' => 'required|unique:events',
        ]);

        $event = new Event();
        //Dados principais
        $event->title      = $request->title;
        $event->active     = $request->active;
        $event->text       = $request->text;
        $event->created_by = Auth::user()->name;

        if($event->save()){
            $images = $request->images;
            if(isset($images)){
                for ($i=0; $i < count($images); $i++) {
                    $img= explode('.',$images[$i]);
                    $extension = $img[1];
                    $new_name = $event->slug.'-'.$i.'.'.$extension;
                    /*Move as imagens do arquivo tmp para a pasta do arquivo */
                    Storage::move('public/tmp/' . $images[$i], 'public/images/events/'.$event->id.'/'.$new_name);
                    /*Cadastra as imagens no banco de dados */
                    $eventImage = new EventImage();
                    $eventImage->title=$new_name;
                    $eventImage->featured=$request->featured[$i];
                    $eventImage->event_id=$event->id;
                    $eventImage->path='images/events/'.$event->id.'/';
                    $eventImage->save();
                    unset($eventImage);
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
     * @param  \App\Model\Admin\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        if($event){
            $image = $event->images()->where('featured',1)->first();
            $data = array(
                'title' => $event->title,
                'body'  => array(
                    'Título'            => $event->title,
                    'Visualizações'     => $event->clicks,
                    'Criado em'         => ($event->created_at ? date( 'd/m/Y H:i' , strtotime($event->created_at)) : ""),
                    'Criado por'        => $event->created_by,
                    'Atualizado em'     => ($event->updated_at ? date( 'd/m/Y H:i' , strtotime($event->updated_at)) : ""),
                    'Atualizado por'    => $event->updated_by,
                    'image'            => ($image ? url('storage/images/events/'.$event->id.'/'.$image->title) : url('storage/images/logos/logo.png') )
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
     * @param  \App\Model\Admin\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $images = $event->images()->get();
        return view('admin.events.form',[
            'title_postfix'     => $event->title,
            'navigation'        => $this->navigation,
            'data'              => $event,
            'images'            => $images,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Admin\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required',
        ]);
        $images = $request->image;

        //Dados principais
        $event->title = $request->title;
        $event->active = $request->active;
        $event->text = $request->text;
        $event->updated_because = $request->updated_because;
        $event->updated_by = Auth::user()->name;

            /*Pega as imagens que não foram excluidas na pasta */
            $files = Storage::allFiles('public/images/events/'.$event->id);
            if(isset($files)){
                for ($i=0; $i < count($files); $i++) {
                    /*Pega nome da imagem */
                    $name = explode('/',$files[$i]);
                    $image_name = $name[4];
                    /*Move as imagens para o arquivo temporário */
                    Storage::move($files[$i], 'public/tmp/' . $image_name);
                }
                /*Limpa a pasta do arquivo */
                Storage::deleteDirectory('public/images/events/'.$event->id);
            }
        if($event->save()){
            DB::table('event_images')->where('event_id', $event->id)->delete();
            $images = $request->images;
            if(isset($images)){
                for ($i=0; $i < count($images); $i++) {
                    $img= explode('.',$images[$i]);
                    $extension = $img[1];
                    $new_name = $event->slug.'-'.$i.'.'.$extension;
                    /*Move as imagens do arquivo tmp para a pasta do arquivo */
                    Storage::move('public/tmp/' . $images[$i], 'public/images/events/'.$event->id.'/'.$new_name);
                    /*Cadastra as imagens no banco de dados */

                    $eventImage = new EventImage();
                    $eventImage->title=$new_name;
                    $eventImage->featured=$request->featured[$i];
                    $eventImage->event_id=$event->id;
                    $eventImage->path='images/events/'.$event->id.'/';
                    $eventImage->save();
                    unset($eventImage);
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
     * @param  \App\Model\Admin\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Event $event)
    {
        $event->active = '3';
        $event->deleted_because = $event->motive;
        $event->deleted_by = Auth::user()->name;
        $event->deleted_at = date( 'Y-m-d H:i:s');

        if($event->save()){
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
