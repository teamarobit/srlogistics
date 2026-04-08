<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CRStateSJCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 898,
'name' => 'Acosta'
],[
'state_id' => 898,
'name' => 'Alajuelita'
],[
'state_id' => 898,
'name' => 'Aserrí'
],[
'state_id' => 898,
'name' => 'Calle Blancos'
],[
'state_id' => 898,
'name' => 'Colima'
],[
'state_id' => 898,
'name' => 'Colón'
],[
'state_id' => 898,
'name' => 'Curridabat'
],[
'state_id' => 898,
'name' => 'Daniel Flores'
],[
'state_id' => 898,
'name' => 'Desamparados'
],[
'state_id' => 898,
'name' => 'Dota'
],[
'state_id' => 898,
'name' => 'Escazú'
],[
'state_id' => 898,
'name' => 'Goicoechea'
],[
'state_id' => 898,
'name' => 'Granadilla'
],[
'state_id' => 898,
'name' => 'Guadalupe'
],[
'state_id' => 898,
'name' => 'Ipís'
],[
'state_id' => 898,
'name' => 'León Cortés'
],[
'state_id' => 898,
'name' => 'Mercedes'
],[
'state_id' => 898,
'name' => 'Montes de Oca'
],[
'state_id' => 898,
'name' => 'Mora'
],[
'state_id' => 898,
'name' => 'Moravia'
],[
'state_id' => 898,
'name' => 'Palmichal'
],[
'state_id' => 898,
'name' => 'Patarrá'
],[
'state_id' => 898,
'name' => 'Puriscal'
],[
'state_id' => 898,
'name' => 'Purral'
],[
'state_id' => 898,
'name' => 'Pérez Zeledón'
],[
'state_id' => 898,
'name' => 'Sabanilla'
],[
'state_id' => 898,
'name' => 'Salitral'
],[
'state_id' => 898,
'name' => 'Salitrillos'
],[
'state_id' => 898,
'name' => 'San Felipe'
],[
'state_id' => 898,
'name' => 'San Ignacio'
],[
'state_id' => 898,
'name' => 'San Isidro'
],[
'state_id' => 898,
'name' => 'San José'
],[
'state_id' => 898,
'name' => 'San Juan'
],[
'state_id' => 898,
'name' => 'San Juan de Dios'
],[
'state_id' => 898,
'name' => 'San Marcos'
],[
'state_id' => 898,
'name' => 'San Miguel'
],[
'state_id' => 898,
'name' => 'San Pedro'
],[
'state_id' => 898,
'name' => 'San Rafael'
],[
'state_id' => 898,
'name' => 'San Rafael Abajo'
],[
'state_id' => 898,
'name' => 'San Rafael Arriba'
],[
'state_id' => 898,
'name' => 'San Vicente'
],[
'state_id' => 898,
'name' => 'San Vicente de Moravia'
],[
'state_id' => 898,
'name' => 'Santa Ana'
],[
'state_id' => 898,
'name' => 'Santiago'
],[
'state_id' => 898,
'name' => 'Tarrazú'
],[
'state_id' => 898,
'name' => 'Tejar'
],[
'state_id' => 898,
'name' => 'Tibás'
],[
'state_id' => 898,
'name' => 'Turrubares'
],[
'state_id' => 898,
'name' => 'Vázquez de Coronado'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
