<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateSMXCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 241,
'name' => 'Qarayeri'
],[
'state_id' => 241,
'name' => 'Qırmızı Samux'
],[
'state_id' => 241,
'name' => 'Samux'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
