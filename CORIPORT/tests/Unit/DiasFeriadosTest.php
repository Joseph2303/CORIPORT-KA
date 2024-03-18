<?php

namespace Tests\Unit;

use Tests\TestCase;

class DiasFeriadosTest extends TestCase
{
    /**
     * Test retrieving all holidays.
     *
     * @return void
     */
    public function test_get_all_holidays(): void
    {

        $response = $this->json('GET', 'api/dias_feriados');

        $response->assertStatus(200);

        $responseData = $response->json();

        $this->assertEquals(200, $responseData['status']);
        $this->assertArrayHasKey('data', $responseData);


    }

    public function test_get_holiday(): void
    {
                $response = $this->json('GET', 'api/dias_feriados/show/' . 1);

                $response->assertStatus(200);
        
                $responseData = $response->json();
        
                $this->assertEquals(200, $responseData['status']);
                $this->assertArrayHasKey('data', $responseData);
    }

    public function test_the_application_updates_holiday_data_successfully()
    {
 

        $updatedHolidayData = [
            'fecha' => '2022-12-25',
            'descripcion' => 'Navidad Actualizada',
            'tipoFeriado' => 'Feriado Nacional Actualizado',
        ];

        $updateResponse = $this->json('PUT', "api/dias_feriados/update/1", ['data' => json_encode($updatedHolidayData)]);

        $updateResponse->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Datos actualizados satisfactoriamente',
            ]);
    }
}
