<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GWStateTOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1562,
'name' => 'Catió'
],[
'state_id' => 1562,
'name' => 'Quebo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
