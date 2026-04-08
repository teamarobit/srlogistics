<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateSALCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 250,
'name' => 'Qaraçala'
],[
'state_id' => 250,
'name' => 'Salyan'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
