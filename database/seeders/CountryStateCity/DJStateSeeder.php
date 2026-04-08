<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class DJStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 60,
'name' => 'Obock Region',
'iso2' => 'OB'
],[
'country_id' => 60,
'name' => 'Djibouti',
'iso2' => 'DJ'
],[
'country_id' => 60,
'name' => 'Dikhil Region',
'iso2' => 'DI'
],[
'country_id' => 60,
'name' => 'Tadjourah Region',
'iso2' => 'TA'
],[
'country_id' => 60,
'name' => 'Arta Region',
'iso2' => 'AR'
],[
'country_id' => 60,
'name' => 'Ali Sabieh Region',
'iso2' => 'AS'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
