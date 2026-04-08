<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HNStateOLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1602,
'name' => 'Arimís'
],[
'state_id' => 1602,
'name' => 'Campamento'
],[
'state_id' => 1602,
'name' => 'Catacamas'
],[
'state_id' => 1602,
'name' => 'Concordia'
],[
'state_id' => 1602,
'name' => 'Dulce Nombre de Culmí'
],[
'state_id' => 1602,
'name' => 'El Guayabito'
],[
'state_id' => 1602,
'name' => 'El Rosario'
],[
'state_id' => 1602,
'name' => 'El Rusio'
],[
'state_id' => 1602,
'name' => 'Esquipulas del Norte'
],[
'state_id' => 1602,
'name' => 'Gualaco'
],[
'state_id' => 1602,
'name' => 'Guarizama'
],[
'state_id' => 1602,
'name' => 'Guata'
],[
'state_id' => 1602,
'name' => 'Guayape'
],[
'state_id' => 1602,
'name' => 'Jano'
],[
'state_id' => 1602,
'name' => 'Juticalpa'
],[
'state_id' => 1602,
'name' => 'Jutiquile'
],[
'state_id' => 1602,
'name' => 'La Concepción'
],[
'state_id' => 1602,
'name' => 'La Estancia'
],[
'state_id' => 1602,
'name' => 'La Guata'
],[
'state_id' => 1602,
'name' => 'La Unión'
],[
'state_id' => 1602,
'name' => 'Laguna Seca'
],[
'state_id' => 1602,
'name' => 'Mangulile'
],[
'state_id' => 1602,
'name' => 'Manto'
],[
'state_id' => 1602,
'name' => 'Municipio de San Francisco de La Paz'
],[
'state_id' => 1602,
'name' => 'Patuca'
],[
'state_id' => 1602,
'name' => 'Punuare'
],[
'state_id' => 1602,
'name' => 'Salamá'
],[
'state_id' => 1602,
'name' => 'San Esteban'
],[
'state_id' => 1602,
'name' => 'San Francisco de Becerra'
],[
'state_id' => 1602,
'name' => 'San Francisco de la Paz'
],[
'state_id' => 1602,
'name' => 'San José de Río Tinto'
],[
'state_id' => 1602,
'name' => 'San Nicolás'
],[
'state_id' => 1602,
'name' => 'Santa María del Real'
],[
'state_id' => 1602,
'name' => 'Silca'
],[
'state_id' => 1602,
'name' => 'Yocón'
],[
'state_id' => 1602,
'name' => 'Zopilotepe'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
