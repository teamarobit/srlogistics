<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStateWCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 175,
'name' => 'Alvear'
],[
'state_id' => 175,
'name' => 'Berón de Astrada'
],[
'state_id' => 175,
'name' => 'Bonpland'
],[
'state_id' => 175,
'name' => 'Chavarría'
],[
'state_id' => 175,
'name' => 'Concepción'
],[
'state_id' => 175,
'name' => 'Corrientes'
],[
'state_id' => 175,
'name' => 'Cruz de los Milagros'
],[
'state_id' => 175,
'name' => 'Curuzú Cuatiá'
],[
'state_id' => 175,
'name' => 'Departamento de Bella Vista'
],[
'state_id' => 175,
'name' => 'Departamento de Berón de Astrada'
],[
'state_id' => 175,
'name' => 'Departamento de Capital'
],[
'state_id' => 175,
'name' => 'Departamento de Concepción'
],[
'state_id' => 175,
'name' => 'Departamento de Curuzú Cuatiá'
],[
'state_id' => 175,
'name' => 'Departamento de Empedrado'
],[
'state_id' => 175,
'name' => 'Departamento de Esquina'
],[
'state_id' => 175,
'name' => 'Departamento de General Alvear'
],[
'state_id' => 175,
'name' => 'Departamento de General Paz'
],[
'state_id' => 175,
'name' => 'Departamento de Goya'
],[
'state_id' => 175,
'name' => 'Departamento de Itatí'
],[
'state_id' => 175,
'name' => 'Departamento de Ituzaingó'
],[
'state_id' => 175,
'name' => 'Departamento de Lavalle'
],[
'state_id' => 175,
'name' => 'Departamento de Mburucuyá'
],[
'state_id' => 175,
'name' => 'Departamento de Mercedes'
],[
'state_id' => 175,
'name' => 'Departamento de Monte Caseros'
],[
'state_id' => 175,
'name' => 'Departamento de Paso de los Libres'
],[
'state_id' => 175,
'name' => 'Departamento de Saladas'
],[
'state_id' => 175,
'name' => 'Departamento de San Cosme'
],[
'state_id' => 175,
'name' => 'Departamento de San Luis del Palmar'
],[
'state_id' => 175,
'name' => 'Departamento de San Martín'
],[
'state_id' => 175,
'name' => 'Departamento de San Miguel'
],[
'state_id' => 175,
'name' => 'Departamento de San Roque'
],[
'state_id' => 175,
'name' => 'Departamento de Santo Tomé'
],[
'state_id' => 175,
'name' => 'Departamento de Sauce'
],[
'state_id' => 175,
'name' => 'Empedrado'
],[
'state_id' => 175,
'name' => 'Esquina'
],[
'state_id' => 175,
'name' => 'Felipe Yofré'
],[
'state_id' => 175,
'name' => 'Garruchos'
],[
'state_id' => 175,
'name' => 'Gobernador Juan E. Martínez'
],[
'state_id' => 175,
'name' => 'Gobernador Virasora'
],[
'state_id' => 175,
'name' => 'Goya'
],[
'state_id' => 175,
'name' => 'Herlitzka'
],[
'state_id' => 175,
'name' => 'Itatí'
],[
'state_id' => 175,
'name' => 'Ituzaingó'
],[
'state_id' => 175,
'name' => 'Itá Ibaté'
],[
'state_id' => 175,
'name' => 'Juan Pujol'
],[
'state_id' => 175,
'name' => 'La Cruz'
],[
'state_id' => 175,
'name' => 'Libertad'
],[
'state_id' => 175,
'name' => 'Lomas de Vallejos'
],[
'state_id' => 175,
'name' => 'Loreto'
],[
'state_id' => 175,
'name' => 'Mariano I. Loza'
],[
'state_id' => 175,
'name' => 'Mburucuyá'
],[
'state_id' => 175,
'name' => 'Mercedes'
],[
'state_id' => 175,
'name' => 'Mocoretá'
],[
'state_id' => 175,
'name' => 'Monte Caseros'
],[
'state_id' => 175,
'name' => 'Nuestra Señora del Rosario de Caa Catí'
],[
'state_id' => 175,
'name' => 'Nueve de Julio'
],[
'state_id' => 175,
'name' => 'Palmar Grande'
],[
'state_id' => 175,
'name' => 'Paso de la Patria'
],[
'state_id' => 175,
'name' => 'Paso de los Libres'
],[
'state_id' => 175,
'name' => 'Pedro R. Fernández'
],[
'state_id' => 175,
'name' => 'Perugorría'
],[
'state_id' => 175,
'name' => 'Pueblo Libertador'
],[
'state_id' => 175,
'name' => 'Riachuelo'
],[
'state_id' => 175,
'name' => 'Saladas'
],[
'state_id' => 175,
'name' => 'San Carlos'
],[
'state_id' => 175,
'name' => 'San Cosme'
],[
'state_id' => 175,
'name' => 'San Lorenzo'
],[
'state_id' => 175,
'name' => 'San Luis del Palmar'
],[
'state_id' => 175,
'name' => 'San Miguel'
],[
'state_id' => 175,
'name' => 'Santa Lucía'
],[
'state_id' => 175,
'name' => 'Santa Rosa'
],[
'state_id' => 175,
'name' => 'Santo Tomé'
],[
'state_id' => 175,
'name' => 'Yapeyú'
],[
'state_id' => 175,
'name' => 'Yataity Calle'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
