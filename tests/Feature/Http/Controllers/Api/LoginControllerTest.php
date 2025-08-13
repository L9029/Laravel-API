<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que valida el login de un usuario y la generación de su token.
     *
     * @return void
     */
    public function test_user_can_login_and_receive_token(): void
    {
        // Crea un usuario en la base de datos
        $user = User::factory()->create();

        // Datos que se enviaran al formulario
        $data = [
            "email" => $user->email,
            "password" => 'password',
            'device' => 'iphone'
        ];

        // Realiza la solicitud POST al endpoint de login, verifica que la respuesta sea exitosa y que el token se haya generado correctamente
        $this->postJson('/api/login', $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'token',
            ]);

        // Verifica que el token pertenece al usuario
        $this->assertNotNull($user->tokens()->first());
    }

    /**
     * Test que valida que el login falle con credenciales incorrectas.
     *
     * @return void
     */
    public function test_login_fails_with_invalid_credentials(): void
    {
        // Se crea un usuario en la base de datos
        User::factory()->create();

        // Datos de login incorrectos
        $data = [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
            'device' => 'iphone'
        ];

        // Realiza la solicitud POST al endpoint de login y verifica que la respuesta sea un error 401 (Unauthorized)
        $this->postJson('/api/login', $data)
            ->assertStatus(401)
            ->assertJsonFragment([
                'message' => 'Unauthorized'
            ]);

        // Verifica que no se haya generado ningún token
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_type' => User::class,
        ]);
    }
}
