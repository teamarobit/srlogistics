<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CDStateHUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 869,
'name' => 'Isiro'
],[
'state_id' => 869,
'name' => 'Wamba'
],[
'state_id' => 869,
'name' => 'Watsa'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
