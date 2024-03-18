<?php

namespace Tests\Unit;

use Tests\TestCase;

class PuestoTest extends TestCase
{
    /**
     * Test the show function.
     *
     * @return void
     */
    public function test_show_puesto_by_id(): void
    {

        $response = $this->json('GET', 'api/puesto/show/' . 1);

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertEquals(200, $responseData['status']);
        $this->assertArrayHasKey('data', $responseData);

    }
}
