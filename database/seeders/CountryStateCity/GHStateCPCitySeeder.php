<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GHStateCPCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1444,
'name' => 'Apam'
],[
'state_id' => 1444,
'name' => 'Cape Coast'
],[
'state_id' => 1444,
'name' => 'Dunkwa'
],[
'state_id' => 1444,
'name' => 'Elmina'
],[
'state_id' => 1444,
'name' => 'Foso'
],[
'state_id' => 1444,
'name' => 'Kasoa'
],[
'state_id' => 1444,
'name' => 'Mumford'
],[
'state_id' => 1444,
'name' => 'Saltpond'
],[
'state_id' => 1444,
'name' => 'Swedru'
],[
'state_id' => 1444,
'name' => 'Winneba'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
