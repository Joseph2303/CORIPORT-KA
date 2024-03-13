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

        // Llamar a la función para obtener todos los usuarios
        $response = $this->json('GET', 'api/users');

        // Verificar que la respuesta tiene un código de estado 200
        $response->assertStatus(200);

        // Decodificar el contenido JSON de la respuesta
        $responseData = $response->json();

        // Verificar que la respuesta tiene la estructura esperada
        $this->assertEquals(200, $responseData['status']);
        $this->assertArrayHasKey('data', $responseData);
        // Verificar que se devuelven al menos tres usuarios (o el número que hayas creado en la fábrica)
        $this->assertCount(4, $responseData['data']);

        //////////--------------

        // Llamar a la función para obtener el usuario por su ID
        $response = $this->json('GET', 'api/userId/' . 2);

        // Verificar que la respuesta tiene un código de estado 200
        $response->assertStatus(200);

        // Decodificar el contenido JSON de la respuesta
        $responseData = $response->json();

    }
}
