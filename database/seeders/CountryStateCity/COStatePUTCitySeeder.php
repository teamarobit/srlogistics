<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStatePUTCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 841,
'name' => 'Colón'
],[
'state_id' => 841,
'name' => 'Mocoa'
],[
'state_id' => 841,
'name' => 'Orito'
],[
'state_id' => 841,
'name' => 'Puerto Asís'
],[
'state_id' => 841,
'name' => 'Puerto Guzmán'
],[
'state_id' => 841,
'name' => 'Puerto Leguízamo'
],[
'state_id' => 841,
'name' => 'San Francisco'
],[
'state_id' => 841,
'name' => 'San Miguel'
],[
'state_id' => 841,
'name' => 'Santiago'
],[
'state_id' => 841,
'name' => 'Sibundoy'
],[
'state_id' => 841,
'name' => 'Valle del Guamuez'
],[
'state_id' => 841,
'name' => 'Villagarzón'
],[
'state_id' => 841,
'name' => 'Puerto Caicedo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
