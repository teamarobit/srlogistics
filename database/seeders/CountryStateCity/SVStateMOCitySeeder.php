<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class SVStateMOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1182,
'name' => 'Cacaopera'
],[
'state_id' => 1182,
'name' => 'Corinto'
],[
'state_id' => 1182,
'name' => 'Guatajiagua'
],[
'state_id' => 1182,
'name' => 'Jocoro'
],[
'state_id' => 1182,
'name' => 'San Francisco'
],[
'state_id' => 1182,
'name' => 'Sociedad'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
