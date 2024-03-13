<?php

namespace Tests\Unit;

use Tests\TestCase;

class EmpleadoTest extends TestCase
{
    /**
     * Test the show function to retrieve all employees.
     *
     * @return void
     */
    public function test_show_all_empleados(): void
    {
        // Llamar a la función para obtener todos los empleados
        $response = $this->json('GET', 'api/empleados');

        // Verificar que la respuesta tiene un código de estado 200
        $response->assertStatus(200);

        // Decodificar el contenido JSON de la respuesta
        $responseData = $response->json();

        // Verificar que la respuesta tiene la estructura esperada
        $this->assertEquals(200, $responseData['status']);
        $this->assertArrayHasKey('data', $responseData);

        //////////////------------------------------------

        $response = $this->json('GET', 'api/empleado/show/5');

        // Verificar que la respuesta tiene un código de estado 200
        $response->assertStatus(200);

        // Decodificar el contenido JSON de la respuesta
        $responseData = $response->json();

        // Verificar que la respuesta tiene la estructura esperada
        $this->assertEquals(200, $responseData['status']);
        $this->assertArrayHasKey('data', $responseData);
    }
}
