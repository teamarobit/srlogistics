<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class PKStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 167,
'name' => 'Islamabad Capital Territory',
'iso2' => 'IS'
],[
'country_id' => 167,
'name' => 'Gilgit-Baltistan',
'iso2' => 'GB'
],[
'country_id' => 167,
'name' => 'Khyber Pakhtunkhwa',
'iso2' => 'KP'
],[
'country_id' => 167,
'name' => 'Azad Kashmir',
'iso2' => 'JK'
],[
'country_id' => 167,
'name' => 'Federally Administered Tribal Areas',
'iso2' => 'TA'
],[
'country_id' => 167,
'name' => 'Balochistan',
'iso2' => 'BA'
],[
'country_id' => 167,
'name' => 'Sindh',
'iso2' => 'SD'
],[
'country_id' => 167,
'name' => 'Punjab',
'iso2' => 'PB'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
