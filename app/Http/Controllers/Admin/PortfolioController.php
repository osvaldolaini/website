<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Model\Admin\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\Facades\Image;

class PortfolioController extends Controller
{
    //navegação
    private $navigation = array('title'=>'Portifolios','link'=>'portfolio.index');
    private $new_navigation = array('title'=>'Novo trabalho ','link'=>'portfolio.create');
    //textos para as mensagens e títulos
    private $configs = array(
        'new'                   => 'Novo trabalho ',
        'msg-success-save'      => 'Trabalho cadastrado com sucesso',
        'msg-error-save'        => 'Não foi possivel cadastrar o trabalho',
        'msg-success-delete'    => 'Trabalho excluido com sucesso',
        'msg-error-delete'      => 'Não foi possivel excluir o trabalho',
        'msg-not-found'         => 'Trabalho não encontrado',
        'location'              => 'portifolios',
    );


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $works = Portfolio::all();
        $data[]=array(null,null, null);
        if (isset($works)) {
            $data=array();
            foreach ($works as $work) {
                $buttons = Functions::buttons($work->id,10,$this->configs['location'],true);
                $data[]=array(
                    $work->title,
                    Functions::status($work->active),
                    $buttons,
                );
            }
        }

        return view('admin.portfolios.listAll',[
            'title_postfix' => 'Portifólio',
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
        return view('admin.portfolios.form',[
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
            'title' => 'required|unique:portfolios',
            'link' => 'required|unique:portfolios',
        ]);

        $work = new Portfolio();
        //Dados principais
        $work->title = $request->title;
        $work->active = $request->active;
        $work->link = $request->link;
        $work->created_by = Auth::user()->name;

        if($work->save()){
            if(isset($request->image)){
                Storage::delete(['public/images/portfolios/'.$work->id.'.jpg', 'public/images/portfolios/'.$work->id.'.png','public/images/portfolios/'.$work->id.'.jpeg','public/images/portfolios/'.$work->id.'.webp']);
                $img= explode('.',$request->image);
                $extension = $img[1];
                $work->image = $work->id.'.'.$extension;
                $work->save();
                /*Move as imagens do arquivo tmp para a pasta do arquivo */
                Storage::move('public/tmp/' . $request->image, 'public/images/portfolios/'. $work->image);
                // open file a image resource
                $img = Image::make('storage/images/portfolios/'. $work->image);
                // resize the image to a height of 300 and constrain aspect ratio (auto width)
                $img->resize(null, 120, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save('storage/images/portfolios/'. $work->image, 90);
                // salvar em webp
                $webp = Image::make('storage/images/portfolios/'. $work->image)->encode('webp', 100);
                $webp->save('storage/images/portfolios/'.$work->id.'_thumbnail.webp', 100);

            }else{
                if(!isset($request->imageRemove)){
                    Storage::delete(['public/images/portfolios/'.$work->id.'.jpg', 'public/images/portfolios/'.$work->id.'.png','public/images/portfolios/'.$work->id.'.jpeg','public/images/portfolios/'.$work->id.'.webp']);
                    $work->image = null;
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
     * @param  \App\Model\Admin\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function show(Portfolio $portfolio)
    {
        if($portfolio){
            $data = array(
                'title' => $portfolio->title,
                'body'  => array(
                    'Empresa / Cliente' => $portfolio->title,
                    'Criado em'         => ($portfolio->created_at ? date( 'd/m/Y H:i' , strtotime($portfolio->created_at)) : ""),
                    'Criado por'        => $portfolio->created_by,
                    'Atualizado em'     => ($portfolio->updated_at ? date( 'd/m/Y H:i' , strtotime($portfolio->updated_at)) : ""),
                    'Atualizado por'    => $portfolio->updated_by,
                    'image'             => ($portfolio->image ? url('storage/images/portfolios/'.$portfolio->image) : url('storage/images/logos/logo.png') ),
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
     * @param  \App\Model\Admin\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolios.form',[
            'title_postfix'     => $this->configs['new'],
            'navigation'        => $this->navigation,
            'data'              => $portfolio
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Admin\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'title' => 'required',
            'link' => 'required',
            'updated_because' => 'required',
        ]);
        //Dados principais
        //Dados principais
        $portfolio->title = $request->title;
        $portfolio->active = $request->active;
        $portfolio->link = $request->link;
        $portfolio->updated_because = $request->updated_because;
        $portfolio->updated_by = Auth::user()->name;

        //Imagem
        if(isset($request->image)){
            Storage::delete(['public/images/portfolios/'.$portfolio->id.'.jpg', 'public/images/portfolios/'.$portfolio->id.'.png','public/images/portfolios/'.$portfolio->id.'.jpeg','public/images/portfolios/'.$portfolio->id.'.webp']);
            $img= explode('.',$request->image);
            $extension = $img[1];
            $portfolio->image = $portfolio->id.'.'.$extension;
            $portfolio->save();
            /*Move as imagens do arquivo tmp para a pasta do arquivo */
            Storage::move('public/tmp/' . $request->image, 'public/images/portfolios/'. $portfolio->image);
                // open file a image resource
                $img = Image::make('storage/images/portfolios/'. $portfolio->image);
                // resize the image to a height of 300 and constrain aspect ratio (auto width)
                $img->resize(null, 120, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save('storage/images/portfolios/'. $portfolio->image, 90);
                $webp = Image::make('storage/images/portfolios/'. $portfolio->image)->encode('webp', 100);
                $webp->save('storage/images/portfolios/'.$portfolio->id.'_thumbnail.webp', 100);
        }else{
            if(!isset($request->imageRemove)){
                Storage::delete(['public/images/portfolios/'.$portfolio->id.'.jpg', 'public/images/portfolios/'.$portfolio->id.'.png','public/images/portfolios/'.$portfolio->id.'.jpeg','public/images/portfolios/'.$portfolio->id.'.webp']);
                $portfolio->image = null;
            }
        }

        if($portfolio->save()){
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
     * @param  \App\Model\Admin\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Portfolio $portfolio, Request $request)
    {
        $portfolio->active = '3';
        $portfolio->deleted_because = $request->motive;
        $portfolio->deleted_by = Auth::user()->name;
        $portfolio->deleted_at = date( 'Y-m-d H:i:s');

        if($portfolio->save()){
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
