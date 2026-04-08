<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TLStateMFCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1121,
'name' => 'Alas'
],[
'state_id' => 1121,
'name' => 'Fatuberliu'
],[
'state_id' => 1121,
'name' => 'Same'
],[
'state_id' => 1121,
'name' => 'Turiscai'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
