<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AFStateBAMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 3,
'name' => 'Bāmyān'
],[
'state_id' => 3,
'name' => 'Panjāb'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
