<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GAState8CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1400,
'name' => 'Gamba'
],[
'state_id' => 1400,
'name' => 'Omboué'
],[
'state_id' => 1400,
'name' => 'Port-Gentil'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
