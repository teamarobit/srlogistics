<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BOStateSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 494,
'name' => 'Abapó'
],[
'state_id' => 494,
'name' => 'Ascención de Guarayos'
],[
'state_id' => 494,
'name' => 'Ascensión'
],[
'state_id' => 494,
'name' => 'Boyuibe'
],[
'state_id' => 494,
'name' => 'Buena Vista'
],[
'state_id' => 494,
'name' => 'Camiri'
],[
'state_id' => 494,
'name' => 'Charagua'
],[
'state_id' => 494,
'name' => 'Comarapa'
],[
'state_id' => 494,
'name' => 'Concepción'
],[
'state_id' => 494,
'name' => 'Cotoca'
],[
'state_id' => 494,
'name' => 'German Busch'
],[
'state_id' => 494,
'name' => 'Guarayos'
],[
'state_id' => 494,
'name' => 'Jorochito'
],[
'state_id' => 494,
'name' => 'La Bélgica'
],[
'state_id' => 494,
'name' => 'Limoncito'
],[
'state_id' => 494,
'name' => 'Los Negros'
],[
'state_id' => 494,
'name' => 'Mairana'
],[
'state_id' => 494,
'name' => 'Mineros'
],[
'state_id' => 494,
'name' => 'Montero'
],[
'state_id' => 494,
'name' => 'Okinawa Número Uno'
],[
'state_id' => 494,
'name' => 'Pailón'
],[
'state_id' => 494,
'name' => 'Paurito'
],[
'state_id' => 494,
'name' => 'Portachuelo'
],[
'state_id' => 494,
'name' => 'Provincia Andrés Ibáñez'
],[
'state_id' => 494,
'name' => 'Provincia Chiquitos'
],[
'state_id' => 494,
'name' => 'Provincia Cordillera'
],[
'state_id' => 494,
'name' => 'Provincia Florida'
],[
'state_id' => 494,
'name' => 'Provincia Ichilo'
],[
'state_id' => 494,
'name' => 'Provincia Manuel María Caballero'
],[
'state_id' => 494,
'name' => 'Provincia Santiesteban'
],[
'state_id' => 494,
'name' => 'Provincia Sara'
],[
'state_id' => 494,
'name' => 'Provincia Vallegrande'
],[
'state_id' => 494,
'name' => 'Provincia Velasco'
],[
'state_id' => 494,
'name' => 'Provincia Warnes'
],[
'state_id' => 494,
'name' => 'Provincia Ángel Sandoval'
],[
'state_id' => 494,
'name' => 'Provincia Ñuflo de Chávez'
],[
'state_id' => 494,
'name' => 'Puerto Quijarro'
],[
'state_id' => 494,
'name' => 'Puesto de Pailas'
],[
'state_id' => 494,
'name' => 'Roboré'
],[
'state_id' => 494,
'name' => 'Samaipata'
],[
'state_id' => 494,
'name' => 'San Carlos'
],[
'state_id' => 494,
'name' => 'San Ignacio de Velasco'
],[
'state_id' => 494,
'name' => 'San Juan del Surutú'
],[
'state_id' => 494,
'name' => 'San Julian'
],[
'state_id' => 494,
'name' => 'San Matías'
],[
'state_id' => 494,
'name' => 'San Pedro'
],[
'state_id' => 494,
'name' => 'Santa Cruz de la Sierra'
],[
'state_id' => 494,
'name' => 'Santa Rita'
],[
'state_id' => 494,
'name' => 'Santa Rosa del Sara'
],[
'state_id' => 494,
'name' => 'Santiago del Torno'
],[
'state_id' => 494,
'name' => 'Urubichá'
],[
'state_id' => 494,
'name' => 'Vallegrande'
],[
'state_id' => 494,
'name' => 'Villa Yapacaní'
],[
'state_id' => 494,
'name' => 'Warnes'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
