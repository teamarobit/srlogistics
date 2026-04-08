<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState34CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 99,
'name' => 'Bordj Bou Arreridj'
],[
'state_id' => 99,
'name' => 'Bordj Ghdir'
],[
'state_id' => 99,
'name' => 'Bordj Zemoura'
],[
'state_id' => 99,
'name' => 'El Achir'
],[
'state_id' => 99,
'name' => 'Mansourah'
],[
'state_id' => 99,
'name' => 'Melouza'
],[
'state_id' => 99,
'name' => 'Râs el Oued'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
