<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KHState20CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 658,
'name' => 'Srŏk Svay Chrŭm'
],[
'state_id' => 658,
'name' => 'Svay Rieng'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
