<?php

namespace Tests\Feature;

use Tests\TestCase;

class HorarioTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('api/horario/show/3');

        $response->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [  
                '*' => [             
                'idHorario',
                'horaInicio', 
                'horaFin', 
                'fecha', 
                'idEmpleado'
                ],
            ],
        ]);
            
    }
}
