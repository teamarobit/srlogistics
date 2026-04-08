<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TLStateALCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1122,
'name' => 'Aileu'
],[
'state_id' => 1122,
'name' => 'Lequidoe'
],[
'state_id' => 1122,
'name' => 'Remexio'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
