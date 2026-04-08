<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState41CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 126,
'name' => 'Sedrata'
],[
'state_id' => 126,
'name' => 'Souk Ahras'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
