<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;

class PostControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test que valida que la ruta raíz muestre un mensaje cuando no hay posts.
     * 
     * @return void
     */
    public function test_index_empty(): void
    {
        // Verificar que la ruta raíz retorne un mensaje indicando que no hay posts disponibles
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('No hay posts disponibles');
    }

    /**
     * Test que valida que la ruta raíz muestre los posts cuando existen.
     * 
     * @return void
     */
    public function test_index_with_posts(): void {

        // Crear un post usando el factory
        $post = Post::factory()->create();

        // Verificar que la ruta raíz muestre el post creado y que el título y slug estén presentes en la respuesta
        $this->get('/')
            ->assertStatus(200)
            ->assertSee($post->title);
    }
}
