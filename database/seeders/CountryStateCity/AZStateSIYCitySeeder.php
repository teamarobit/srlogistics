<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateSIYCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 289,
'name' => 'Gilgilçay'
],[
'state_id' => 289,
'name' => 'Kyzyl-Burun'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
