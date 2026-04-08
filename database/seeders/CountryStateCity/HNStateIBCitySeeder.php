<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HNStateIBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1597,
'name' => 'Coxen Hole'
],[
'state_id' => 1597,
'name' => 'French Harbor'
],[
'state_id' => 1597,
'name' => 'Guanaja'
],[
'state_id' => 1597,
'name' => 'José Santos Guardiola'
],[
'state_id' => 1597,
'name' => 'Roatán'
],[
'state_id' => 1597,
'name' => 'Sandy Bay'
],[
'state_id' => 1597,
'name' => 'Savannah Bight'
],[
'state_id' => 1597,
'name' => 'Utila'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
