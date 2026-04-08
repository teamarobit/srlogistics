<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BTState21CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 474,
'name' => 'Trongsa'
],[
'state_id' => 474,
'name' => 'Tsirang'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
