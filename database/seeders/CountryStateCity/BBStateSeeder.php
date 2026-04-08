<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class BBStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 20,
'name' => 'Saint Philip',
'iso2' => '10'
],[
'country_id' => 20,
'name' => 'Saint Lucy',
'iso2' => '07'
],[
'country_id' => 20,
'name' => 'Saint Peter',
'iso2' => '09'
],[
'country_id' => 20,
'name' => 'Saint Joseph',
'iso2' => '06'
],[
'country_id' => 20,
'name' => 'Saint James',
'iso2' => '04'
],[
'country_id' => 20,
'name' => 'Saint Thomas',
'iso2' => '11'
],[
'country_id' => 20,
'name' => 'Saint George',
'iso2' => '03'
],[
'country_id' => 20,
'name' => 'Saint John',
'iso2' => '05'
],[
'country_id' => 20,
'name' => 'Christ Church',
'iso2' => '01'
],[
'country_id' => 20,
'name' => 'Saint Andrew',
'iso2' => '02'
],[
'country_id' => 20,
'name' => 'Saint Michael',
'iso2' => '08'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
