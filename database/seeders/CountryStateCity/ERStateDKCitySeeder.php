<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ERStateDKCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1207,
'name' => 'Assab'
],[
'state_id' => 1207,
'name' => 'Edd'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
