<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class SVStateCUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1189,
'name' => 'Cojutepeque'
],[
'state_id' => 1189,
'name' => 'San Martín'
],[
'state_id' => 1189,
'name' => 'Suchitoto'
],[
'state_id' => 1189,
'name' => 'Tecoluca'
],[
'state_id' => 1189,
'name' => 'Tenancingo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
