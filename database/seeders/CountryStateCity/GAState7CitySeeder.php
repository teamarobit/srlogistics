<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GAState7CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1401,
'name' => 'Koulamoutou'
],[
'state_id' => 1401,
'name' => 'Lastoursville'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
