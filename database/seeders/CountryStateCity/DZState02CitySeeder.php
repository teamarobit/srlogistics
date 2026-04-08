<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState02CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 88,
'name' => 'Abou el Hassan'
],[
'state_id' => 88,
'name' => 'Boukadir'
],[
'state_id' => 88,
'name' => 'Chlef'
],[
'state_id' => 88,
'name' => 'Ech Chettia'
],[
'state_id' => 88,
'name' => 'Oued Fodda'
],[
'state_id' => 88,
'name' => 'Oued Sly'
],[
'state_id' => 88,
'name' => 'Sidi Akkacha'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
