<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class INStatePYCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1684,
'name' => 'Karaikal'
],[
'state_id' => 1684,
'name' => 'Mahe'
],[
'state_id' => 1684,
'name' => 'Puducherry'
],[
'state_id' => 1684,
'name' => 'Yanam'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
