<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DJStateOBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1069,
'name' => 'Alaïli Ḏaḏḏa‘'
],[
'state_id' => 1069,
'name' => 'Obock'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
