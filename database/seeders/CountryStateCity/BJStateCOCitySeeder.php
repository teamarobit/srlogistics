<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BJStateCOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 452,
'name' => 'Comé'
],[
'state_id' => 452,
'name' => 'Dassa-Zoumé'
],[
'state_id' => 452,
'name' => 'Savalou'
],[
'state_id' => 452,
'name' => 'Savé'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
