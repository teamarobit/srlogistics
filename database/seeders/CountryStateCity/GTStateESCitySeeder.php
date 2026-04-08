<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GTStateESCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1521,
'name' => 'Escuintla'
],[
'state_id' => 1521,
'name' => 'Guanagazapa'
],[
'state_id' => 1521,
'name' => 'Iztapa'
],[
'state_id' => 1521,
'name' => 'La Democracia'
],[
'state_id' => 1521,
'name' => 'La Gomera'
],[
'state_id' => 1521,
'name' => 'Masagua'
],[
'state_id' => 1521,
'name' => 'Nueva Concepción'
],[
'state_id' => 1521,
'name' => 'Palín'
],[
'state_id' => 1521,
'name' => 'Puerto San José'
],[
'state_id' => 1521,
'name' => 'San Vicente Pacaya'
],[
'state_id' => 1521,
'name' => 'Santa Lucía Cotzumalguapa'
],[
'state_id' => 1521,
'name' => 'Siquinalá'
],[
'state_id' => 1521,
'name' => 'Tiquisate'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
