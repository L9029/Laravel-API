<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\V2\PostResource; // Recurso para formatear los datos de la respuesta
use App\Http\Resources\V2\PostCollection; // Colección de recursos para formatear la respuesta

class PostController extends Controller
{
    /**
     * Retorna una lista de posts paginados.
     * 
     * @return \App\Http\Resources\V2\PostCollection // Colección de recursos de los posts
     */
    public function index()
    {
        $posts = Post::latest()->paginate(12); // Obtener los posts más recientes con paginación

        return new PostCollection($posts); // Devolver la colección de recursos
    }

    /**
     * Retorna un post específico.
     * 
     * @param  \App\Models\Post  $post
     * @return \App\Http\Resources\V2\PostResource // Recurso que formatea la respuesta del post
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }
}
