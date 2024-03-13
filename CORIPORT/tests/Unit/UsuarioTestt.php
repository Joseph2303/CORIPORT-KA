<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Usuario; 

class UsuarioTest extends TestCase
{
    /**
     * Test adding a new user.
     *
     * @return void
     */
    public function test_add_new_user(): void
    {
        // Datos del nuevo usuario
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            // Agrega aquí otros campos del usuario si es necesario
        ];

        // Llamar a la función para agregar un nuevo usuario
        $response = $this->json('POST', 'api/user/store', $userData);

        // Verificar que la respuesta tiene un código de estado 200
        $response->assertStatus(200);

        // Verificar que el usuario se haya creado correctamente en la base de datos
        $this->assertDatabaseHas('users', ['email' => $userData['email']]);
    }
}