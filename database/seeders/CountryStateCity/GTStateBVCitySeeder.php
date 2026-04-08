<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GTStateBVCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1518,
'name' => 'Cubulco'
],[
'state_id' => 1518,
'name' => 'El Chol'
],[
'state_id' => 1518,
'name' => 'Granados'
],[
'state_id' => 1518,
'name' => 'Purulhá'
],[
'state_id' => 1518,
'name' => 'Rabinal'
],[
'state_id' => 1518,
'name' => 'Salamá'
],[
'state_id' => 1518,
'name' => 'San Jerónimo'
],[
'state_id' => 1518,
'name' => 'San Miguel Chicaj'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
