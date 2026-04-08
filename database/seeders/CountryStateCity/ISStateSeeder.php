<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class ISStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 100,
'name' => 'Southern Peninsula Region',
'iso2' => '2'
],[
'country_id' => 100,
'name' => 'Capital Region',
'iso2' => '1'
],[
'country_id' => 100,
'name' => 'Westfjords',
'iso2' => '4'
],[
'country_id' => 100,
'name' => 'Eastern Region',
'iso2' => '7'
],[
'country_id' => 100,
'name' => 'Southern Region',
'iso2' => '8'
],[
'country_id' => 100,
'name' => 'Northwestern Region',
'iso2' => '5'
],[
'country_id' => 100,
'name' => 'Western Region',
'iso2' => '3'
],[
'country_id' => 100,
'name' => 'Northeastern Region',
'iso2' => '6'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
