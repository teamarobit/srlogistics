<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateXVDCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 273,
'name' => 'Hadrut'
],[
'state_id' => 273,
'name' => 'Novyy Karanlug'
],[
'state_id' => 273,
'name' => 'Qırmızı Bazar'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
