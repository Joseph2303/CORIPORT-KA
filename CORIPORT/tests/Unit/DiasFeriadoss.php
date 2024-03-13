<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\DiasFeriados; 

class DiasFeriadosTest extends TestCase
{
    /**
     * Test deleting a holiday with ID 2.
     *
     * @return void
     */
    public function test_delete_holiday_with_id_2(): void
    {
        // Crear un día feriado con ID 2 (esto puede variar dependiendo de cómo se manejen las pruebas de integración)
        $holiday = DiasFeriados::factory()->create(['id' => 2]);

        // Llamar a la función de eliminación del día feriado con ID 2
        $response = $this->json('DELETE', 'api/dias_feriados/delete/2');

        // Verificar que la respuesta tiene un código de estado 200
        $response->assertStatus(200);

        // Verificar que el día feriado con ID 2 no existe en la base de datos después de la eliminación
        $this->assertDatabaseMissing('dias_feriados', ['id' => 2]);
    }
}