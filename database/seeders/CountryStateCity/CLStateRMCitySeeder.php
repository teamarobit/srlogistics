<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CLStateRMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 770,
'name' => 'Buin'
],[
'state_id' => 770,
'name' => 'El Monte'
],[
'state_id' => 770,
'name' => 'La Pintana'
],[
'state_id' => 770,
'name' => 'Lampa'
],[
'state_id' => 770,
'name' => 'Lo Prado'
],[
'state_id' => 770,
'name' => 'Melipilla'
],[
'state_id' => 770,
'name' => 'Paine'
],[
'state_id' => 770,
'name' => 'Peñaflor'
],[
'state_id' => 770,
'name' => 'Puente Alto'
],[
'state_id' => 770,
'name' => 'San Bernardo'
],[
'state_id' => 770,
'name' => 'Santiago'
],[
'state_id' => 770,
'name' => 'Talagante'
],[
'state_id' => 770,
'name' => 'Alhué'
],[
'state_id' => 770,
'name' => 'Calera de Tango'
],[
'state_id' => 770,
'name' => 'Colina'
],[
'state_id' => 770,
'name' => 'Conchalí'
],[
'state_id' => 770,
'name' => 'El Bosque'
],[
'state_id' => 770,
'name' => 'Estación Central'
],[
'state_id' => 770,
'name' => 'Independencia'
],[
'state_id' => 770,
'name' => 'Isla de Maipo'
],[
'state_id' => 770,
'name' => 'La Cisterna'
],[
'state_id' => 770,
'name' => 'La Florida'
],[
'state_id' => 770,
'name' => 'La Granja'
],[
'state_id' => 770,
'name' => 'La Reina'
],[
'state_id' => 770,
'name' => 'Las Condes'
],[
'state_id' => 770,
'name' => 'Lo Barnechea'
],[
'state_id' => 770,
'name' => 'Lo Espejo'
],[
'state_id' => 770,
'name' => 'Macul'
],[
'state_id' => 770,
'name' => 'Maipú'
],[
'state_id' => 770,
'name' => 'María Pinto'
],[
'state_id' => 770,
'name' => 'Padre Hurtado'
],[
'state_id' => 770,
'name' => 'Pedro Aguirre Cerda'
],[
'state_id' => 770,
'name' => 'Peñalolén'
],[
'state_id' => 770,
'name' => 'Pirque'
],[
'state_id' => 770,
'name' => 'Providencia'
],[
'state_id' => 770,
'name' => 'Quilicura'
],[
'state_id' => 770,
'name' => 'Quinta Normal'
],[
'state_id' => 770,
'name' => 'Recoleta'
],[
'state_id' => 770,
'name' => 'Renca'
],[
'state_id' => 770,
'name' => 'San Joaquín'
],[
'state_id' => 770,
'name' => 'San José de Maipo'
],[
'state_id' => 770,
'name' => 'San Miguel'
],[
'state_id' => 770,
'name' => 'San Pedro'
],[
'state_id' => 770,
'name' => 'Tiltil'
],[
'state_id' => 770,
'name' => 'Vitacura'
],[
'state_id' => 770,
'name' => 'Ñuñoa'
],[
'state_id' => 770,
'name' => 'Cerrillos'
],[
'state_id' => 770,
'name' => 'Curacaví'
],[
'state_id' => 770,
'name' => 'Huechuraba'
],[
'state_id' => 770,
'name' => 'Pudahuel'
],[
'state_id' => 770,
'name' => 'San Ramón'
],[
'state_id' => 770,
'name' => 'Cerro Navia'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
