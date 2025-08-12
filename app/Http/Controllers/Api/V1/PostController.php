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
     * @return \App\Http\Resources\V1\PostResource[] // Colección de recursos que formatean la respuesta de los posts
     */
    public function index()
    {
        $posts = Post::latest()->paginate(12);

        // Retorna los posts paginados utilizando el recurso PostResource para formatear la respuesta
        return PostResource::collection($posts);
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
     * Elimina un post específico.
     * 
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json(null, 204); // Respuesta vacía con código de estado 204 No Content
    }
}
