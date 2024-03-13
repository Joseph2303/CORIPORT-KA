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
    public function test_the_application_returns_a_successful_response()
    {

        $puestoData = [
            'puesto' => 'Nuevo Puesto',
        ];

        // Envía una solicitud POST a la ruta de almacenamiento
        $response = $this->json('POST', 'api/puesto/store', ['data' => json_encode($puestoData)]);

        // Verifica que la respuesta tenga un código de estado 200
        $response->assertStatus(200);






        
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
}
