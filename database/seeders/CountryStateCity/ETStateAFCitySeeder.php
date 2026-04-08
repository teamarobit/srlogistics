<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ETStateAFCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1228,
'name' => 'Administrative Zone 2'
],[
'state_id' => 1228,
'name' => 'Administrative Zone 3'
],[
'state_id' => 1228,
'name' => 'Asaita'
],[
'state_id' => 1228,
'name' => 'Dubti'
],[
'state_id' => 1228,
'name' => 'Gewanē'
],[
'state_id' => 1228,
'name' => 'Semera'
],[
'state_id' => 1228,
'name' => 'Āwash'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
