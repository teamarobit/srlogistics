<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BRStateDFCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 544,
'name' => 'Brasília'
],[
'state_id' => 544,
'name' => 'Planaltina'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
