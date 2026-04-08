<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState08CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1085,
'name' => 'Miches'
],[
'state_id' => 1085,
'name' => 'Pedro Sánchez'
],[
'state_id' => 1085,
'name' => 'Santa Cruz de El Seibo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
