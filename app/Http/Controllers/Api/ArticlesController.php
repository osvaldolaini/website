<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Admin\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::select('id','title','slug','created_at','created_by','clicks')->where('active',1)
        ->orderBy('clicks','desc')
        ->orderBy('created_at','desc')
        ->limit(4)->get();

        $apiArticle = array();
        foreach ($articles as $article) {
            $apiArticle[]=array(
                'jpg'           => url('storage/images/articles/'.$article->id.'/thumbnail.jpg'),
                'webp'           => url('storage/images/articles/'.$article->id.'/thumbnail.webp'),
                'alt'           => $article->slug,
                'slug'          => url('artigos/'.$article->slug),
                'title'         => $article->title,
                'clicks'        => $article->clicks,
                'created_by'    => $article->created_by,
                'created_at'    => ($article->created_at ? date( 'd/m/Y H:i' , strtotime($article->created_at)) : ""),
            );
        }
        if(isset($apiArticle)){
            return response()->json(
                [
                    'success'=> true,
                    'data'   => $apiArticle,
                    'more'   => url('nossas-noticias'),
                ]
            );
        }else{
            return response()->json(
                [
                    'success'=> false,
                    'error'=> false,
                ]
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Admin\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Admin\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Admin\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }
}
