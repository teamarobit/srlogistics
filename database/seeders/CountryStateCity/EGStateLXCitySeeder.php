<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateLXCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1172,
'name' => 'Luxor'
],[
'state_id' => 1172,
'name' => 'Markaz al Uqşur'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
