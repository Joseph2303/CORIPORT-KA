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
        $response = $this->json('GET', 'api/empleados');

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertEquals(200, $responseData['status']);
        $this->assertArrayHasKey('data', $responseData);

    }
    public function test_show_empleado(): void
    {
        $response = $this->json('GET', 'api/empleado/show/5');

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertEquals(200, $responseData['status']);
        $this->assertArrayHasKey('data', $responseData);
    }
}
