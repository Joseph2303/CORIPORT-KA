<?php

namespace Tests\Unit;

use Tests\TestCase;

class DiasFeriadosTest extends TestCase
{
    /**
     * Test retrieving all holidays.
     *
     * @return void
     */
    public function test_get_all_holidays(): void
    {

        // Llamar a la función para obtener todos los días feriados
        $response = $this->json('GET', 'api/dias_feriados');

        // Verificar que la respuesta tiene un código de estado 200
        $response->assertStatus(200);

        // Decodificar el contenido JSON de la respuesta
        $responseData = $response->json();

        // Verificar que la respuesta tiene la estructura esperada
        $this->assertEquals(200, $responseData['status']);
        $this->assertArrayHasKey('data', $responseData);
        // Verificar que se devuelven al menos tres días feriados (o el número que hayas creado en la fábrica)
        $this->assertCount(3, $responseData['data']);

        //////////---------
        $response = $this->json('GET', 'api/dias_feriados/' . 1);

        // Verificar que la respuesta tiene un código de estado 200
        $response->assertStatus(200);

        // Decodificar el contenido JSON de la respuesta
        $responseData = $response->json();

        // Verificar que la respuesta tiene la estructura esperada
        $this->assertEquals(200, $responseData['status']);
        $this->assertArrayHasKey('data', $responseData);


    }
}