<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GHStateUECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1447,
'name' => 'Bawku'
],[
'state_id' => 1447,
'name' => 'Bolgatanga'
],[
'state_id' => 1447,
'name' => 'Navrongo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
