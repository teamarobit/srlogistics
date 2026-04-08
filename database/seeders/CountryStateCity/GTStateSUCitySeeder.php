<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GTStateSUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1504,
'name' => 'Chicacao'
],[
'state_id' => 1504,
'name' => 'Cuyotenango'
],[
'state_id' => 1504,
'name' => 'Mazatenango'
],[
'state_id' => 1504,
'name' => 'Municipio de San Antonio Suchitepéquez'
],[
'state_id' => 1504,
'name' => 'Municipio de San Miguel Panán'
],[
'state_id' => 1504,
'name' => 'Municipio de Santa Bárbara'
],[
'state_id' => 1504,
'name' => 'Patulul'
],[
'state_id' => 1504,
'name' => 'Pueblo Nuevo'
],[
'state_id' => 1504,
'name' => 'Río Bravo'
],[
'state_id' => 1504,
'name' => 'San Antonio Suchitepéquez'
],[
'state_id' => 1504,
'name' => 'San Bernardino'
],[
'state_id' => 1504,
'name' => 'San Francisco Zapotitlán'
],[
'state_id' => 1504,
'name' => 'San Gabriel'
],[
'state_id' => 1504,
'name' => 'San José El Ídolo'
],[
'state_id' => 1504,
'name' => 'San Juan Bautista'
],[
'state_id' => 1504,
'name' => 'San Lorenzo'
],[
'state_id' => 1504,
'name' => 'San Miguel Panán'
],[
'state_id' => 1504,
'name' => 'San Pablo Jocopilas'
],[
'state_id' => 1504,
'name' => 'Santa Bárbara'
],[
'state_id' => 1504,
'name' => 'Santo Domingo Suchitepéquez'
],[
'state_id' => 1504,
'name' => 'Santo Tomás La Unión'
],[
'state_id' => 1504,
'name' => 'Zunilito'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
