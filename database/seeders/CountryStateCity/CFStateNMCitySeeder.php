<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CFStateNMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 737,
'name' => 'Baoro'
],[
'state_id' => 737,
'name' => 'Bouar'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
