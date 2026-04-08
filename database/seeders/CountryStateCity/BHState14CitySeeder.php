<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BHState14CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 341,
'name' => 'Ar Rifā‘'
],[
'state_id' => 341,
'name' => 'Dār Kulayb'
],[
'state_id' => 341,
'name' => 'Madīnat ‘Īsá'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
