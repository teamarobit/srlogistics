<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ADState06CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 142,
'name' => 'Sant Julià de Lòria'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
