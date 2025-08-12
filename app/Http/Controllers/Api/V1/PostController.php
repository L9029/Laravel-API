<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\V1\PostResource; // Recurso para formatear los datos de la respuesta

class PostController extends Controller
{
    /**
     * Retorna una lista de posts paginados.
     * 
     * @return \Illuminate\Http\JsonResponse // Respuesta en formato JSON
     */
    public function index()
    {
        $posts = Post::paginate(12);

        return response()->json([
            'posts' => $posts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Retorna un post específico.
     * 
     * @param  \App\Models\Post  $post
     * @return \App\Http\Resources\V1\PostResource // Recurso que formatea la respuesta del post
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
