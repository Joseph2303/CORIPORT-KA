<?php

namespace Tests\Unit;

use Tests\TestCase;

class UsuarioTest extends TestCase
{
    /**
     * Test retrieving all users.
     *
     * @return void
     */
    public function test_get_all_users(): void
    {

        $response = $this->json('GET', 'api/users');

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertEquals(200, $responseData['status']);
        $this->assertArrayHasKey('data', $responseData);

    }


    public function test_get_user(): void
    {
        $response = $this->json('GET', 'api/userId/' . 2);

        $response->assertStatus(200);

    }

    public function test_store_user_with_duplicate_email(): void
    {

        $userData = [
            'email' => 'examplemail22@gmail.com',
            'contrasena' => '123',
            'tipoUsuario' => 'admin'
        ];

        $response = $this->json('POST', 'api/user/store', ['data' => json_encode($userData)]);

        $response->assertStatus(406);

        $response->assertJson(['message' => 'Error en la validación de los datos']);
    }

}
