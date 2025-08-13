<?php

namespace Tests\Feature\Http\Controllers\Api\V2;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que valida que el metodo index del API devuelve una lista de posts.
     * 
     * @return void
     */
    public function test_api_index_returns_posts() : void  {

        Post::factory()->count(3)->create();

        // Realiza la solicitud GET a la ruta del índice de posts y verifica que la respuesta venga en formato JSON con paginación y los datos correctos
        $this->getJson('/api/v2/posts')
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

        // Realiza la solicitud GET a la ruta del índice de posts y verifica que la respuesta venga en formato JSON con paginación y sin datos
        $this->getJson('/api/v2/posts')
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
     * Test que valida que el metodo show del API devuelve un post específico.
     *
     * @return void
     */
    public function test_api_show_returns_post() : void {

        $post = Post::factory()->create();

        // Realiza la solicitud GET a la ruta del post específico y verifica que la respuesta venga en formato JSON con los datos correctos
        $this->getJson('/api/v2/posts/' . $post->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $post->id,
                    'slug' => $post->slug,
                    'user_id' => $post->user_id,
                ]
            ]);
    }
}
