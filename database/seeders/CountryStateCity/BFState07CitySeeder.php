<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BFState07CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 620,
'name' => 'Bazega Province'
],[
'state_id' => 620,
'name' => 'Kombissiri'
],[
'state_id' => 620,
'name' => 'Manga'
],[
'state_id' => 620,
'name' => 'Nahouri Province'
],[
'state_id' => 620,
'name' => 'Pô'
],[
'state_id' => 620,
'name' => 'Zoundweogo Province'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
