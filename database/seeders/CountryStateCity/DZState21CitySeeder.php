<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState21CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 93,
'name' => 'Azzaba'
],[
'state_id' => 93,
'name' => 'Karkira'
],[
'state_id' => 93,
'name' => 'Skikda'
],[
'state_id' => 93,
'name' => 'Tamalous'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
