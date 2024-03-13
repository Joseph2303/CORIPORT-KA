<?php

namespace Tests\Unit;

use Tests\TestCase;

class HorarioTest extends TestCase
{
    /**
     * Test the show function to retrieve all schedules.
     *
     * @return void
     */
    public function test_show_all_horarios(): void
    {


        // Llamar a la función show sin un ID específico para obtener todos los horarios
        $response = $this->json('GET', 'api/horarios');

        // Verificar que la respuesta tiene un código de estado 200
        $response->assertStatus(200);

        // Decodificar el contenido JSON de la respuesta
        $responseData = $response->json();

        // Verificar que la respuesta tiene la estructura esperada
        $this->assertEquals(200, $responseData['status']);
        $this->assertArrayHasKey('data', $responseData);
        // Verificar que se devuelven al menos dos horarios
        $this->assertCount(2, $responseData['data']);
    }
}