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
    
            $response = $this->json('GET', 'api/soliVacaciones/show/' . 6);


            $response->assertStatus(200);
            $responseData = $response->json();

            $this->assertEquals(200, $responseData['status']);
            $this->assertArrayHasKey('data', $responseData);
            
    }
}
