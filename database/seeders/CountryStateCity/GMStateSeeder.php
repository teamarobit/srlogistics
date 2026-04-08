<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class GMStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 80,
'name' => 'Banjul',
'iso2' => 'B'
],[
'country_id' => 80,
'name' => 'West Coast Division',
'iso2' => 'W'
],[
'country_id' => 80,
'name' => 'Upper River Division',
'iso2' => 'U'
],[
'country_id' => 80,
'name' => 'Central River Division',
'iso2' => 'M'
],[
'country_id' => 80,
'name' => 'Lower River Division',
'iso2' => 'L'
],[
'country_id' => 80,
'name' => 'North Bank Division',
'iso2' => 'N'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
