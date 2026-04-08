<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BJStateKOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 453,
'name' => 'Djakotomey'
],[
'state_id' => 453,
'name' => 'Dogbo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
