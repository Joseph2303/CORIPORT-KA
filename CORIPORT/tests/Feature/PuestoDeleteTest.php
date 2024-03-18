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
    public function test_the_application_delete_a_puesto()
    {


        $deleteResponse = $this->json('DELETE', "api/puesto/delete/" . 11);

        $deleteResponse->assertStatus(200);


    }
}
