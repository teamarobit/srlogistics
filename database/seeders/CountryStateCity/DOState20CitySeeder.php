<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState20CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1102,
'name' => 'Las Terrenas'
],[
'state_id' => 1102,
'name' => 'Samaná'
],[
'state_id' => 1102,
'name' => 'Sánchez'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
