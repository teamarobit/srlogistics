<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BZStateBZCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 446,
'name' => 'Belize City'
],[
'state_id' => 446,
'name' => 'San Pedro'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
