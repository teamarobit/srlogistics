<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ETStateBECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1231,
'name' => 'Asosa'
],[
'state_id' => 1231,
'name' => 'Metekel'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
