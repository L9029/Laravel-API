<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que valida que un usuario tiene muchos posts.
     * 
     * @return void
     */
    public function test_user_has_many_posts(): void
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->posts);
    }
}
