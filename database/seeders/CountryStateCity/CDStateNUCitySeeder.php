<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CDStateNUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 872,
'name' => 'Bosobolo'
],[
'state_id' => 872,
'name' => 'Businga'
],[
'state_id' => 872,
'name' => 'Gbadolite'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
