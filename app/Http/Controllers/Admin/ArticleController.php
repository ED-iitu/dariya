<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\ArticleToCategory;
use App\Category;
use App\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::all();

        return view('adminPanel.article.index', [
            'articles' => $articles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories  = Category::all();
        $authors = Author::all();

        return view('adminPanel.article.create', [
            'categories' => $categories,
            'authors' => $authors,
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

        $data = [
            'name'         => $request->name,
            'preview_text' => $request->preview_text,
            'detail_text'  => $request->detail_text,
            'author'    => $request->author,
            'lang'         => $request->lang,
            'image_link' => null
        ];
        $image_link = $request->file('image_link');
        if($image_link){
            $extensionImage = $image_link->getClientOriginalExtension();
            Storage::disk('public')->put($image_link->getFilename().'.'.$extensionImage,  File::get($image_link));
            $data['image_link']   = '/uploads/' . $image_link->getFilename() . '.' . $extensionImage;
        }

        $article = Article::create($data);
        ArticleToCategory::query()->where('article_id',$article->id)->delete();

        foreach ($request->categories as $category_id){
            $link = new ArticleToCategory([
                'article_id' => $article->id,
                'category_id' => $category_id
            ]);
            $link->save();
        }

        return redirect()->route('articlesPage')
            ->with('success','Статья успешно добавлена.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return view('adminPanel.article.show',compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $categories  = Category::all();
        return view('adminPanel.article.edit',[
            'article' => $article,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $image_link = $request->file('image_link');

        if (null !== $image_link) {
            $extensionImage = $image_link->getClientOriginalExtension();
            Storage::disk('public')->put($image_link->getFilename().'.'.$extensionImage,  File::get($image_link));
        }


        $data = [
            'name'         => $request->name,
            'preview_text' => $request->preview_text,
            'detail_text'  => $request->detail_text,
            'author'    => $request->author,
            'lang'         => $request->lang,
        ];

        if (null !== $image_link) {
            $data = array_merge($data, [
                'image_link'   => '/uploads/' . $image_link->getFilename() . '.' . $extensionImage,
            ]);
        }


        $article->update($data);

        ArticleToCategory::query()->where('article_id',$article->id)->delete();

        foreach ($request->categories as $category_id){
            $link = new ArticleToCategory([
                'article_id' => $article->id,
                'category_id' => $category_id
            ]);
            $link->save();
        }

        return redirect()->route('articlesPage')
            ->with('success','Статья успешно обновлена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article $article
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articlesPage')
            ->with('success','Статься успешно удалена');
    }
}
