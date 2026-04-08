<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BJStateMOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 457,
'name' => 'Commune of Athieme'
],[
'state_id' => 457,
'name' => 'Lokossa'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
