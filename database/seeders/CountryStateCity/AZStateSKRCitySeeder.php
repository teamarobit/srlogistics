<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateSKRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 288,
'name' => 'Dolyar'
],[
'state_id' => 288,
'name' => 'Dzagam'
],[
'state_id' => 288,
'name' => 'Qasım İsmayılov'
],[
'state_id' => 288,
'name' => 'Shamkhor'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
