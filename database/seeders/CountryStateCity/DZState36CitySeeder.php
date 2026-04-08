<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState36CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 83,
'name' => 'Ben Mehidi'
],[
'state_id' => 83,
'name' => 'Besbes'
],[
'state_id' => 83,
'name' => 'El Kala'
],[
'state_id' => 83,
'name' => 'El Tarf'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
