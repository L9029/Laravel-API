<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que valida que el metodo index del API devuelve una lista de posts.
     * 
     * @return void
     */
    public function test_api_index_returns_posts() : void {

        Post::factory()->count(3)->create();

        // Realiza la solicitud GET a la ruta del índice de posts y verifica que la respuesta venga en formato JSON con paginación y los datos correctos
        $this->getJson('/api/v1/posts')
            ->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'slug',
                        'excerpt',
                        'content',
                        'published_at',
                        'user_id',
                    ]
                ],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next'
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'path',
                    'per_page',
                    'to',
                    'total'
                ]
            ]);
    }

    /**
     * Test que valida que el metodo index del API devuelve una lista vacía cuando no hay posts.
     * 
     * @return void
     */
    public function test_api_index_returns_empty_when_no_posts() : void {

        // Realiza la solicitud GET a la ruta del índice de posts y verifica que la respuesta venga en formato JSON con paginación pero sin datos
        $this->getJson('/api/v1/posts')
            ->assertStatus(200)
            ->assertJsonCount(0, 'data')
            ->assertJsonStructure([
                'data' => [],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next'
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'path',
                    'per_page',
                    'to',
                    'total'
                ]
            ]);
    }

    /**
     * Test que valida que el metodo store del API crea un nuevo post.
     * 
     * @return void
     */
    public function test_api_store() : void {

        // Crea un usuario para asociar al post
        $user = User::factory()->create();

        // Define los datos del nuevo post
        $post = [
            'title' => 'Nuevo Post',
            'slug' => 'nuevo-post',
            'content' => 'Contenido del nuevo post',
            'user_id' => $user->id,
        ];

        // Realiza la solicitud POST a la ruta de creación de posts y verifica que la respuesta sea correcta
        $this->postJson('/api/v1/posts', $post)
            ->assertStatus(201)
            ->assertJsonFragment([
                'slug' => 'nuevo-post',
                'user_id' => $user->id,
            ]);
        
        // Verifica que el post se haya creado en la base de datos
        $this->assertDatabaseHas('posts', $data);
    }

    /**
     * Test que valida que el metodo show del API devuelve un post específico.
     * 
     * @return void
     */
    public function test_api_show() : void {
        
        // Crea un post para probar
        $post = Post::factory()->create();

        // Realiza la solicitud GET a la ruta de un post específico y verifica la respuesta
        $this->getJson('/api/v1/posts/' . $post->id)
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $post->id,
                'slug' => $post->slug,
                'user_id' => $post->user_id,
            ]);
    }

    /**
     * Test que valida que el metodo update del API actualiza un post existente.
     * 
     * @return void
     */
    public function test_api_update() : void {

        // Crea un post
        $post = Post::factory()->create();

        // Se definen los datos actualizados del post
        $data = [
            'title' => 'Post Actualizado',
            'slug' => 'post-actualizado',
            'content' => 'Contenido del post actualizado',
        ];

        // Realiza la solicitud PUT a la ruta de actualización del post y verifica la respuesta
        $this->putJson("/api/v1/posts/{$post->id}", $data)
            ->assertStatus(200)
            ->assertJsonFragment([
                'title' => 'Post Actualizado',
                'slug' => 'post-actualizado',
                'content' => 'Contenido del post actualizado',
            ]);
        
        // Verifica que el post se haya actualizado en la base de datos
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Post Actualizado',
            'slug' => 'post-actualizado',
            'content' => 'Contenido del post actualizado',
        ]);
    }

    /**
     * Test que valida que el metodo destroy del API elimina un post existente.
     * 
     * @return void
     */
    public function test_api_destroy() : void {

        // Se crea un post para eliminar
        $post = Post::factory()->create();

        // Realiza la solicitud DELETE a la ruta de eliminación del post y verifica la respuesta
        $this->deleteJson("/api/v1/posts/{$post->id}")
            ->assertStatus(204);

        // Verifica que el post se haya eliminado de la base de datos
        $this->assertDatabaseMissing('posts', $post->toArray());
    }
}
