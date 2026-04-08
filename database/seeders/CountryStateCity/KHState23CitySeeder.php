<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KHState23CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 664,
'name' => 'Krong Kep'
],[
'state_id' => 664,
'name' => 'Srŏk Dâmnăk Châng’aeur'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
