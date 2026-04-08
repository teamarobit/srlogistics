<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class INStateNLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1691,
'name' => 'Dimapur'
],[
'state_id' => 1691,
'name' => 'Kohima'
],[
'state_id' => 1691,
'name' => 'Mokokchung'
],[
'state_id' => 1691,
'name' => 'Mon'
],[
'state_id' => 1691,
'name' => 'Peren'
],[
'state_id' => 1691,
'name' => 'Phek'
],[
'state_id' => 1691,
'name' => 'Tuensang'
],[
'state_id' => 1691,
'name' => 'Tuensang District'
],[
'state_id' => 1691,
'name' => 'Wokha'
],[
'state_id' => 1691,
'name' => 'Zunheboto'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
