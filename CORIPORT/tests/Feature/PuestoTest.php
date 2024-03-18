<?php

namespace Tests\Feature;

use Tests\TestCase;

class PuestoTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response_all_puestos()
    {

        $response = $this->get('api/puestos');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    '*' => [
                        'idPuesto',
                        'puesto'
                    ],
                ],
            ]);
    }
    public function test_the_application_returns_a_successful_response_store_puesto()
    {
        $puestoData = [
            'puesto' => 'Nuevo Puesto',
        ];

        $response = $this->json('POST', 'api/puesto/store', ['data' => json_encode($puestoData)]);

        $response->assertStatus(200);
    }
}
