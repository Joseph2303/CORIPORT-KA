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


        $response = $this->json('GET', 'api/horarios');

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertEquals(200, $responseData['status']);
        $this->assertArrayHasKey('data', $responseData);
        $this->assertCount(2, $responseData['data']);
    }
}