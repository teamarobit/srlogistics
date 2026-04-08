<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GHStateBECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1450,
'name' => 'Techiman'
],[
'state_id' => 1450,
'name' => 'Techiman North'
],[
'state_id' => 1450,
'name' => 'Atebubu-Amantin'
],[
'state_id' => 1450,
'name' => 'Kintampo North'
],[
'state_id' => 1450,
'name' => 'Kintampo South'
],[
'state_id' => 1450,
'name' => 'Nkoranza North'
],[
'state_id' => 1450,
'name' => 'Nkoranza South'
],[
'state_id' => 1450,
'name' => 'Pru West'
],[
'state_id' => 1450,
'name' => 'Pru East'
],[
'state_id' => 1450,
'name' => 'Sene East'
],[
'state_id' => 1450,
'name' => 'Sene West'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
