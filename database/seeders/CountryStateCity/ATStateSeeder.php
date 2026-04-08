<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class ATStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 15,
'name' => 'Carinthia',
'iso2' => '2'
],[
'country_id' => 15,
'name' => 'Upper Austria',
'iso2' => '4'
],[
'country_id' => 15,
'name' => 'Styria',
'iso2' => '6'
],[
'country_id' => 15,
'name' => 'Vienna',
'iso2' => '9'
],[
'country_id' => 15,
'name' => 'Salzburg',
'iso2' => '5'
],[
'country_id' => 15,
'name' => 'Burgenland',
'iso2' => '1'
],[
'country_id' => 15,
'name' => 'Vorarlberg',
'iso2' => '8'
],[
'country_id' => 15,
'name' => 'Tyrol',
'iso2' => '7'
],[
'country_id' => 15,
'name' => 'Lower Austria',
'iso2' => '3'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
