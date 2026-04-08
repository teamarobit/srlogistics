<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BHState13CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 340,
'name' => 'Jidd Ḩafş'
],[
'state_id' => 340,
'name' => 'Manama'
],[
'state_id' => 340,
'name' => 'Sitrah'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
