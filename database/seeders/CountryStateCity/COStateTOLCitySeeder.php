<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateTOLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 828,
'name' => 'Alpujarra'
],[
'state_id' => 828,
'name' => 'Alvarado'
],[
'state_id' => 828,
'name' => 'Ambalema'
],[
'state_id' => 828,
'name' => 'Anzoátegui'
],[
'state_id' => 828,
'name' => 'Armero'
],[
'state_id' => 828,
'name' => 'Ataco'
],[
'state_id' => 828,
'name' => 'Cajamarca'
],[
'state_id' => 828,
'name' => 'Carmen de Apicalá'
],[
'state_id' => 828,
'name' => 'Casabianca'
],[
'state_id' => 828,
'name' => 'Chaparral'
],[
'state_id' => 828,
'name' => 'Coello'
],[
'state_id' => 828,
'name' => 'Coyaima'
],[
'state_id' => 828,
'name' => 'Cunday'
],[
'state_id' => 828,
'name' => 'Dolores'
],[
'state_id' => 828,
'name' => 'Espinal'
],[
'state_id' => 828,
'name' => 'Falan'
],[
'state_id' => 828,
'name' => 'Flandes'
],[
'state_id' => 828,
'name' => 'Fresno'
],[
'state_id' => 828,
'name' => 'Guamo'
],[
'state_id' => 828,
'name' => 'Herveo'
],[
'state_id' => 828,
'name' => 'Honda'
],[
'state_id' => 828,
'name' => 'Ibagué'
],[
'state_id' => 828,
'name' => 'Icononzo'
],[
'state_id' => 828,
'name' => 'Lérida'
],[
'state_id' => 828,
'name' => 'Líbano'
],[
'state_id' => 828,
'name' => 'Melgar'
],[
'state_id' => 828,
'name' => 'Murillo'
],[
'state_id' => 828,
'name' => 'Natagaima'
],[
'state_id' => 828,
'name' => 'Ortega'
],[
'state_id' => 828,
'name' => 'Palocabildo'
],[
'state_id' => 828,
'name' => 'Piedras'
],[
'state_id' => 828,
'name' => 'Planadas'
],[
'state_id' => 828,
'name' => 'Prado'
],[
'state_id' => 828,
'name' => 'Purificación'
],[
'state_id' => 828,
'name' => 'Rioblanco'
],[
'state_id' => 828,
'name' => 'Roncesvalles'
],[
'state_id' => 828,
'name' => 'Rovira'
],[
'state_id' => 828,
'name' => 'Saldaña'
],[
'state_id' => 828,
'name' => 'San Antonio'
],[
'state_id' => 828,
'name' => 'San Luis'
],[
'state_id' => 828,
'name' => 'San Sebastián de Mariquita'
],[
'state_id' => 828,
'name' => 'Santa Isabel'
],[
'state_id' => 828,
'name' => 'Suárez'
],[
'state_id' => 828,
'name' => 'Valle de San Juan'
],[
'state_id' => 828,
'name' => 'Venadillo'
],[
'state_id' => 828,
'name' => 'Villahermosa'
],[
'state_id' => 828,
'name' => 'Villarrica'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
