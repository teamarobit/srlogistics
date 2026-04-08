<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ECStateECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1145,
'name' => 'Esmeraldas'
],[
'state_id' => 1145,
'name' => 'Muisne'
],[
'state_id' => 1145,
'name' => 'Pampanal de Bolívar'
],[
'state_id' => 1145,
'name' => 'Rio Verde'
],[
'state_id' => 1145,
'name' => 'Rosa Zarate'
],[
'state_id' => 1145,
'name' => 'San Lorenzo de Esmeraldas'
],[
'state_id' => 1145,
'name' => 'Valdez'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
