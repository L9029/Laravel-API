<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que valida que un post pertenece a un usuario.
     * 
     * @return void
     */
    public function test_post_belongs_to_user(): void
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(User::class, $post->user);
    }

    /**
     * Test que valida que el atributo 'excerpt' se genera correctamente.
     * 
     * @return void
     */
    public function test_get_excerpt_attribute(): void
    {
        // Crear un post con contenido largo
        $post = Post::factory()->create([
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. This is a test content for the post. It should be truncated.',
        ]);

        // Verificar que el excerpt se genera correctamente
        $this->assertEquals('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed...', $post->excerpt);
    }

    /**
     * Test que valida que el atributo 'published_at' se formatea correctamente.
     * 
     * @return void
     */
    public function test_get_published_at_attribute(): void 
    {
        // Se crear un post con una fecha específica
        $post = Post::factory()->create([
            'created_at' => '2025-10-15 12:00:00',
        ]);

        // Verificar que la fecha se formatea correctamente
        $this->assertEquals('15/10/2025', $post->published_at);
    }
}
