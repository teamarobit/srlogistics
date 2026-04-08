<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BFState03CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 607,
'name' => 'Kadiogo Province'
],[
'state_id' => 607,
'name' => 'Ouagadougou'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
