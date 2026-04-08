<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AFStateKNRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 7,
'name' => 'Asadabad'
],[
'state_id' => 7,
'name' => 'Āsmār'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
