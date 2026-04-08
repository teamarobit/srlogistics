<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CVStateTSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 727,
'name' => 'Tarrafal de São Nicolau'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
