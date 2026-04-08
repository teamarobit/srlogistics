<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GTStateGUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1516,
'name' => 'Amatitlán'
],[
'state_id' => 1516,
'name' => 'Chinautla'
],[
'state_id' => 1516,
'name' => 'Chuarrancho'
],[
'state_id' => 1516,
'name' => 'Fraijanes'
],[
'state_id' => 1516,
'name' => 'Guatemala City'
],[
'state_id' => 1516,
'name' => 'Mixco'
],[
'state_id' => 1516,
'name' => 'Palencia'
],[
'state_id' => 1516,
'name' => 'Petapa'
],[
'state_id' => 1516,
'name' => 'San José Pinula'
],[
'state_id' => 1516,
'name' => 'San José del Golfo'
],[
'state_id' => 1516,
'name' => 'San Juan Sacatepéquez'
],[
'state_id' => 1516,
'name' => 'San Pedro Ayampuc'
],[
'state_id' => 1516,
'name' => 'San Pedro Sacatepéquez'
],[
'state_id' => 1516,
'name' => 'San Raimundo'
],[
'state_id' => 1516,
'name' => 'Santa Catarina Pinula'
],[
'state_id' => 1516,
'name' => 'Villa Canales'
],[
'state_id' => 1516,
'name' => 'Villa Nueva'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
