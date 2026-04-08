<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BJStateAQCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 461,
'name' => 'Abomey-Calavi'
],[
'state_id' => 461,
'name' => 'Allada'
],[
'state_id' => 461,
'name' => 'Hinvi'
],[
'state_id' => 461,
'name' => 'Hévié'
],[
'state_id' => 461,
'name' => 'Ouidah'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
