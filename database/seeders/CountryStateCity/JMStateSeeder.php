<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class JMStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 108,
'name' => 'Westmoreland Parish',
'iso2' => '10'
],[
'country_id' => 108,
'name' => 'Saint Elizabeth Parish',
'iso2' => '11'
],[
'country_id' => 108,
'name' => 'Saint Ann Parish',
'iso2' => '06'
],[
'country_id' => 108,
'name' => 'Saint James Parish',
'iso2' => '08'
],[
'country_id' => 108,
'name' => 'Saint Catherine Parish',
'iso2' => '14'
],[
'country_id' => 108,
'name' => 'Saint Mary Parish',
'iso2' => '05'
],[
'country_id' => 108,
'name' => 'Kingston Parish',
'iso2' => '01'
],[
'country_id' => 108,
'name' => 'Hanover Parish',
'iso2' => '09'
],[
'country_id' => 108,
'name' => 'Saint Thomas Parish',
'iso2' => '03'
],[
'country_id' => 108,
'name' => 'Saint Andrew',
'iso2' => '02'
],[
'country_id' => 108,
'name' => 'Portland Parish',
'iso2' => '04'
],[
'country_id' => 108,
'name' => 'Clarendon Parish',
'iso2' => '13'
],[
'country_id' => 108,
'name' => 'Manchester Parish',
'iso2' => '12'
],[
'country_id' => 108,
'name' => 'Trelawny Parish',
'iso2' => '07'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
