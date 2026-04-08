<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateYEVCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 228,
'name' => 'Aran'
],[
'state_id' => 228,
'name' => 'Qaramanlı'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
