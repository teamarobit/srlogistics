<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ERStateGBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1206,
'name' => 'Ak’ordat'
],[
'state_id' => 1206,
'name' => 'Barentu'
],[
'state_id' => 1206,
'name' => 'Teseney'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
