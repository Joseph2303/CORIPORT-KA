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

        $response = $this->json('GET', 'api/justificacionAusencias');

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertEquals(200, $responseData['status']);
        $this->assertArrayHasKey('data', $responseData);
        $this->assertCount(3, $responseData['data']);
    }
}