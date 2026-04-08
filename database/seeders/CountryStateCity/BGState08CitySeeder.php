<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState08CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 580,
'name' => 'Balchik'
],[
'state_id' => 580,
'name' => 'Dobrich'
],[
'state_id' => 580,
'name' => 'General Toshevo'
],[
'state_id' => 580,
'name' => 'Kavarna'
],[
'state_id' => 580,
'name' => 'Krushari'
],[
'state_id' => 580,
'name' => 'Obshtina Balchik'
],[
'state_id' => 580,
'name' => 'Obshtina Dobrich'
],[
'state_id' => 580,
'name' => 'Obshtina Dobrich-Selska'
],[
'state_id' => 580,
'name' => 'Obshtina General Toshevo'
],[
'state_id' => 580,
'name' => 'Obshtina Kavarna'
],[
'state_id' => 580,
'name' => 'Obshtina Krushari'
],[
'state_id' => 580,
'name' => 'Obshtina Shabla'
],[
'state_id' => 580,
'name' => 'Obshtina Tervel'
],[
'state_id' => 580,
'name' => 'Shabla'
],[
'state_id' => 580,
'name' => 'Tervel'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
