<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ECStateHCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1148,
'name' => 'Alausí'
],[
'state_id' => 1148,
'name' => 'Guano'
],[
'state_id' => 1148,
'name' => 'Riobamba'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
