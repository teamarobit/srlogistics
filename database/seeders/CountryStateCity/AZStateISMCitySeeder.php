<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateISMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 269,
'name' => 'Basqal'
],[
'state_id' => 269,
'name' => 'İsmayıllı'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
