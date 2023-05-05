<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with(['user', 'tags'])->latest()->simplePaginate(2);

        return response()->json($articles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $articles = Article::pluck('name', 'id');

        $tags = Tag::pluck('name', 'id');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        // $article = Article::create([
        //     'title' => $request->title,
        //     'slug' => Str::slug($request->title),
        //     'description' => $request->description,
        //     'status' => $request->status === 'on',
        //     'user_id' => auth()->id,
        //     'category_id' => $request->category_id,
        // ]);

        $article = Article::create([
            'slug' => Str::slug($request->title),
            'status' => $request->status === 'on',
            'user_id' => $request->user()->id,
        ] + $request->validated());

        $article->tags()->attach($request->tags);

        return response()->json($article);
    }

    /**
     * Display the specified resource.
     */
    // public function show($slug)
    public function show(Article $article)
    {
        return response()->json($article);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $article($request->validated() + [
            'slug' => Str::slug($request->title)
        ]);

        $article->tags()->sync($request->tags);

        return response()->json($article);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
    }
}
