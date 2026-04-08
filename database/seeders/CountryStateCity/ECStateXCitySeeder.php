<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ECStateXCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1144,
'name' => 'La Maná'
],[
'state_id' => 1144,
'name' => 'Latacunga'
],[
'state_id' => 1144,
'name' => 'Pujilí'
],[
'state_id' => 1144,
'name' => 'San Miguel de Salcedo'
],[
'state_id' => 1144,
'name' => 'Saquisilí'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
