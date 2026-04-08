<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class LBStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 121,
'name' => 'South',
'iso2' => 'JA'
],[
'country_id' => 121,
'name' => 'Mount Lebanon',
'iso2' => 'JL'
],[
'country_id' => 121,
'name' => 'Baalbek-Hermel',
'iso2' => 'BH'
],[
'country_id' => 121,
'name' => 'North',
'iso2' => 'AS'
],[
'country_id' => 121,
'name' => 'Akkar',
'iso2' => 'AK'
],[
'country_id' => 121,
'name' => 'Beirut',
'iso2' => 'BA'
],[
'country_id' => 121,
'name' => 'Beqaa',
'iso2' => 'BI'
],[
'country_id' => 121,
'name' => 'Nabatieh',
'iso2' => 'NA'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
