<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class AGStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 10,
'name' => 'Redonda',
'iso2' => '11'
],[
'country_id' => 10,
'name' => 'Saint Peter Parish',
'iso2' => '07'
],[
'country_id' => 10,
'name' => 'Saint Paul Parish',
'iso2' => '06'
],[
'country_id' => 10,
'name' => 'Saint John Parish',
'iso2' => '04'
],[
'country_id' => 10,
'name' => 'Saint Mary Parish',
'iso2' => '05'
],[
'country_id' => 10,
'name' => 'Barbuda',
'iso2' => '10'
],[
'country_id' => 10,
'name' => 'Saint George Parish',
'iso2' => '03'
],[
'country_id' => 10,
'name' => 'Saint Philip Parish',
'iso2' => '08'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
