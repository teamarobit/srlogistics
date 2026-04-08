<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AGState04CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 166,
'name' => 'Potters Village'
],[
'state_id' => 166,
'name' => 'Saint John’s'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
