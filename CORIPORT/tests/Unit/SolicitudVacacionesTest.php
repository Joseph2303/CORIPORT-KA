<?php

namespace Tests\Unit;

use Tests\TestCase;

class SolicitudVacacionesTest extends TestCase
{
    /**
     * Test the show function.
     *
     * @return void
     */
    public function test_show_solicitudVacaciones_by_id(): void
    {
    
            // Llamar a la función show con el ID del puesto creado
            $response = $this->json('GET', 'api/soliVacaciones/show/' . 6);

            // Verificar que la respuesta tiene un código de estado 200

            $response->assertStatus(200);
            // Decodificar el contenido JSON de la respuesta
            $responseData = $response->json();

            // Verificar que la respuesta tiene la estructura esperada
            $this->assertEquals(200, $responseData['status']);
            $this->assertArrayHasKey('data', $responseData);
            
    }
}
