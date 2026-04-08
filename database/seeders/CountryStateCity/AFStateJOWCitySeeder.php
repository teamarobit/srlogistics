<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AFStateJOWCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 17,
'name' => 'Darzāb'
],[
'state_id' => 17,
'name' => 'Qarqīn'
],[
'state_id' => 17,
'name' => 'Shibirghān'
],[
'state_id' => 17,
'name' => 'Āqchah'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
