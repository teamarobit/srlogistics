<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AFStateFYBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 20,
'name' => 'Andkhoy'
],[
'state_id' => 20,
'name' => 'Maymana'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
