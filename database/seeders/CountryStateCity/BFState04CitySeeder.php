<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BFState04CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 633,
'name' => 'Garango'
],[
'state_id' => 633,
'name' => 'Koupéla'
],[
'state_id' => 633,
'name' => 'Kouritenga Province'
],[
'state_id' => 633,
'name' => 'Ouargaye'
],[
'state_id' => 633,
'name' => 'Province du Boulgou'
],[
'state_id' => 633,
'name' => 'Province du Koulpélogo'
],[
'state_id' => 633,
'name' => 'Tenkodogo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
