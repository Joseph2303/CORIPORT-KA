<?php

namespace Tests\Unit;

use Tests\TestCase;

class JustificacionAusenciaTest extends TestCase
{
    /**
     * Test the show function to retrieve all absence justifications.
     *
     * @return void
     */
    public function test_show_all_justificaciones_ausencias(): void
    {

        // Llamar a la función específico para obtener todas las justificaciones de ausencias
        $response = $this->json('GET', 'api/justificacionAusencias');

        // Verificar que la respuesta tiene un código de estado 200
        $response->assertStatus(200);

        // Decodificar el contenido JSON de la respuesta
        $responseData = $response->json();

        // Verificar que la respuesta tiene la estructura esperada
        $this->assertEquals(200, $responseData['status']);
        $this->assertArrayHasKey('data', $responseData);
        // Verificar que se devuelven al menos dos justificaciones de ausencias
        $this->assertCount(3, $responseData['data']);
    }
}