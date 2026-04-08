<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GYStateESCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1581,
'name' => 'Parika'
],[
'state_id' => 1581,
'name' => 'Vreed-en-Hoop'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
