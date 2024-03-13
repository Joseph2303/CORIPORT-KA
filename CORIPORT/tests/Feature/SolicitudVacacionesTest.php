<?php

namespace Tests\Feature;

use Tests\TestCase;

class SolicitudVacacionesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {

        $response = $this->get('api/soliVacaciones');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    '*' => [
                        'idSoliVacaciones',
                        'fechSolicitud',
                        'fechInicio',
                        'fechFin',
                        'estado',
                        'responsableAut',
                        'descripcion',
                        'idEmpleado'
                    ],
                ],
            ]);
            
    }
}
