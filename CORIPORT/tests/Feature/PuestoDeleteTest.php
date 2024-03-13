<?php

namespace Tests\Feature;

use Tests\TestCase;

class PuestoDeleteTest extends TestCase
{
    /**
     * Test the application successfully deletes a puesto.
     *
     * @return void
     */
    public function test_the_application_deletes_a_puesto()
    {


        // Envía una solicitud DELETE para eliminar el puesto recién creado
        $deleteResponse = $this->json('DELETE', "api/puesto/delete/" . 11);

        // Verifica que la respuesta de eliminación tenga un código de estado 200
        $deleteResponse->assertStatus(200);


    }
}
