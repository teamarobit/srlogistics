<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DMState03CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1077,
'name' => 'Castle Bruce'
],[
'state_id' => 1077,
'name' => 'Rosalie'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
