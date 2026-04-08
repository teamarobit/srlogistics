<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class INStateDHCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1705,
'name' => 'Dadra'
],[
'state_id' => 1705,
'name' => 'Dadra & Nagar Haveli'
],[
'state_id' => 1705,
'name' => 'Daman'
],[
'state_id' => 1705,
'name' => 'Diu'
],[
'state_id' => 1705,
'name' => 'Silvassa'
],[
'state_id' => 1705,
'name' => 'Amli'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
