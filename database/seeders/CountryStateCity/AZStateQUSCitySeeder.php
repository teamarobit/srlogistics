<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateQUSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 293,
'name' => 'Qusar'
],[
'state_id' => 293,
'name' => 'Samur'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
