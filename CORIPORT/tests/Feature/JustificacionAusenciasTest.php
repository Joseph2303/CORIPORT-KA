<?php

namespace Tests\Feature;

use Tests\TestCase;

class JustificacionAusenciasTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {

        $response = $this->get('api/justificacionAusencia/show/1');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'idJustificacionAusencia',
                    'fechaSolicitud',
                    'fechaAusencia',
                    'archivos',
                    'justificacion',
                    'estado',
                    'descripcion',
                    'NombreEncargado',
                    'idEmpleado'
                ],
            ]);
    }
}
