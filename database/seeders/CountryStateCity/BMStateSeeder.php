<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class BMStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 25,
'name' => 'Devonshire Parish',
'iso2' => 'DEV'
],[
'country_id' => 25,
'name' => 'Hamilton Parish',
'iso2' => 'HA'
],[
'country_id' => 25,
'name' => 'Paget Parish',
'iso2' => 'PAG'
],[
'country_id' => 25,
'name' => 'Pembroke Parish',
'iso2' => 'PEM'
],[
'country_id' => 25,
'name' => 'Saint Georges Parish',
'iso2' => 'SGE'
],[
'country_id' => 25,
'name' => 'Sandys Parish',
'iso2' => 'SAN'
],[
'country_id' => 25,
'name' => 'Smiths Parish,',
'iso2' => 'SMI'
],[
'country_id' => 25,
'name' => 'Southampton Parish',
'iso2' => 'SOU'
],[
'country_id' => 25,
'name' => 'Warwick Parish',
'iso2' => 'WAR'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
