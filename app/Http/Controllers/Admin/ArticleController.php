<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Model\Admin\Article;
use App\Model\Admin\ArticleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    //navegação
    private $navigation = array('title'=>'Notícias','link'=>'article.index');
    private $new_navigation = array('title'=>'Nova notícia ','link'=>'article.create');
    //textos para as mensagens e títulos
    private $configs = array(
        'new'                   => 'Nova notícia ',
        'msg-success-save'      => 'Notícia cadastrada com sucesso',
        'msg-error-save'        => 'Não foi possivel cadastrar a notícia',
        'msg-success-delete'    => 'Notícia excluida com sucesso',
        'msg-error-delete'      => 'Não foi possivel excluir a notícia',
        'msg-not-found'         => 'Notícia não encontrada',
        'location'              => 'noticias',
    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::all();
        $data[]=array(null,null, null,null);
        if (isset($articles)) {
            $data=array();
            foreach ($articles as $article) {
                $buttons = Functions::buttons($article->id,10,$this->configs['location'],true);
                $data[]=array(
                    $article->title,
                    $article->created_by,
                    Functions::status($article->active),
                    $buttons,
                );
            }
        }

        return view('admin.articles.listAll',[
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
        return view('admin.articles.form',[
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
            'title' => 'required|unique:articles',
        ]);

        $article = new Article();
        //Dados principais
        $article->title      = $request->title;
        $article->active     = $request->active;
        $article->text       = $request->text;
        $article->created_by = Auth::user()->name;

        if($article->save()){
            $images = $request->images;
            if(isset($images)){
                for ($i=0; $i < count($images); $i++) {
                    $img= explode('.',$images[$i]);
                    $extension = $img[1];
                    $new_name = $article->slug.'-'.$i.'.'.$extension;
                    /*Move as imagens do arquivo tmp para a pasta do arquivo */
                    Storage::move('public/tmp/' . $images[$i], 'public/images/articles/'.$article->id.'/'.$new_name);
                    /*Cadastra as imagens no banco de dados */
                    $articleImage = new ArticleImage();
                    $articleImage->title=$new_name;
                    $articleImage->featured=$request->featured[$i];
                    $articleImage->article_id=$article->id;
                    $articleImage->path='images/articles/'.$article->id.'/';
                    $articleImage->save();
                    unset($articleImage);
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
     * @param  \App\Model\Admin\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        if($article){
            $image = $article->images()->where('featured',1)->first();
            $data = array(
                'title' => $article->title,
                'body'  => array(
                    'Título'            => $article->title,
                    'Visualizações'     => $article->clicks,
                    'Criado em'         => ($article->created_at ? date( 'd/m/Y H:i' , strtotime($article->created_at)) : ""),
                    'Criado por'        => $article->created_by,
                    'Atualizado em'     => ($article->updated_at ? date( 'd/m/Y H:i' , strtotime($article->updated_at)) : ""),
                    'Atualizado por'    => $article->updated_by,
                    'image'            => ($image ? url('storage/images/articles/'.$article->id.'/'.$image->title) : url('storage/images/logos/logo.png') )
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
     * @param  \App\Model\Admin\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $images = $article->images()->get();
        return view('admin.articles.form',[
            'title_postfix'     => $article->title,
            'navigation'        => $this->navigation,
            'data'              => $article,
            'images'            => $images,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Admin\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required',
        ]);
        $images = $request->image;

        //Dados principais
        $article->title = $request->title;
        $article->active = $request->active;
        $article->text = $request->text;
        $article->updated_because = $request->updated_because;
        $article->updated_by = Auth::user()->name;

            /*Pega as imagens que não foram excluidas na pasta */
            $files = Storage::allFiles('public/images/articles/'.$article->id);
            if(isset($files)){
                for ($i=0; $i < count($files); $i++) {
                    /*Pega nome da imagem */
                    $name = explode('/',$files[$i]);
                    $image_name = $name[4];
                    /*Move as imagens para o arquivo temporário */
                    Storage::move($files[$i], 'public/tmp/' . $image_name);
                }
                /*Limpa a pasta do arquivo */
                Storage::deleteDirectory('public/images/articles/'.$article->id);
            }
        if($article->save()){
            DB::table('article_images')->where('article_id', $article->id)->delete();
            $images = $request->images;
            if(isset($images)){
                for ($i=0; $i < count($images); $i++) {
                    $img= explode('.',$images[$i]);
                    $extension = $img[1];
                    $new_name = $article->slug.'-'.$i.'.'.$extension;
                    /*Move as imagens do arquivo tmp para a pasta do arquivo */
                    Storage::move('public/tmp/' . $images[$i], 'public/images/articles/'.$article->id.'/'.$new_name);
                    /*Cadastra as imagens no banco de dados */

                    $articleImage = new ArticleImage();
                    $articleImage->title=$new_name;
                    $articleImage->featured=$request->featured[$i];
                    $articleImage->article_id=$article->id;
                    $articleImage->path='images/articles/'.$article->id.'/';
                    $articleImage->save();
                    unset($articleImage);
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
     * @param  \App\Model\Admin\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Article $article)
    {
        $article->active = '3';
        $article->deleted_because = $article->motive;
        $article->deleted_by = Auth::user()->name;
        $article->deleted_at = date( 'Y-m-d H:i:s');

        if($article->save()){
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
