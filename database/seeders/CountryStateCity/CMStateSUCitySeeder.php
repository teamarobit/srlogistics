<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CMStateSUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 686,
'name' => 'Akom II'
],[
'state_id' => 686,
'name' => 'Ambam'
],[
'state_id' => 686,
'name' => 'Kribi'
],[
'state_id' => 686,
'name' => 'Lolodorf'
],[
'state_id' => 686,
'name' => 'Mvangué'
],[
'state_id' => 686,
'name' => 'Mvila'
],[
'state_id' => 686,
'name' => 'Sangmélima'
],[
'state_id' => 686,
'name' => 'Ébolowa'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
