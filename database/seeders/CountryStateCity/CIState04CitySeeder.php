<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CIState04CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 922,
'name' => 'Botro'
],[
'state_id' => 922,
'name' => 'Bouaké'
],[
'state_id' => 922,
'name' => 'Béoumi'
],[
'state_id' => 922,
'name' => 'Dabakala'
],[
'state_id' => 922,
'name' => 'Gbêkê'
],[
'state_id' => 922,
'name' => 'Hambol'
],[
'state_id' => 922,
'name' => 'Katiola'
],[
'state_id' => 922,
'name' => 'Sakassou'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
