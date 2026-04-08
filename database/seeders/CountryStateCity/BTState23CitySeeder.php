<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BTState23CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 479,
'name' => 'Pajo'
],[
'state_id' => 479,
'name' => 'Punākha'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
