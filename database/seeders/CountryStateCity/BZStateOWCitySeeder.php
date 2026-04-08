<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BZStateOWCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 450,
'name' => 'Hopelchén'
],[
'state_id' => 450,
'name' => 'Orange Walk'
],[
'state_id' => 450,
'name' => 'Shipyard'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
