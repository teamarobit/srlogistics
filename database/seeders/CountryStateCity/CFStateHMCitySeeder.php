<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CFStateHMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 735,
'name' => 'Obo'
],[
'state_id' => 735,
'name' => 'Zemio'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
