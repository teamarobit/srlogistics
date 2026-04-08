<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateBALCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 265,
'name' => 'Belokany'
],[
'state_id' => 265,
'name' => 'Qabaqçöl'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
