<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TDStateMOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 747,
'name' => 'Mboursou Léré'
],[
'state_id' => 747,
'name' => 'Pala'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
