<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class NZStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 158,
'name' => 'Northland Region',
'iso2' => 'NTL'
],[
'country_id' => 158,
'name' => 'Manawatu-Wanganui Region',
'iso2' => 'MWT'
],[
'country_id' => 158,
'name' => 'Waikato Region',
'iso2' => 'WKO'
],[
'country_id' => 158,
'name' => 'Otago Region',
'iso2' => 'OTA'
],[
'country_id' => 158,
'name' => 'Marlborough Region',
'iso2' => 'MBH'
],[
'country_id' => 158,
'name' => 'West Coast Region',
'iso2' => 'WTC'
],[
'country_id' => 158,
'name' => 'Wellington Region',
'iso2' => 'WGN'
],[
'country_id' => 158,
'name' => 'Canterbury Region',
'iso2' => 'CAN'
],[
'country_id' => 158,
'name' => 'Chatham Islands',
'iso2' => 'CIT'
],[
'country_id' => 158,
'name' => 'Gisborne District',
'iso2' => 'GIS'
],[
'country_id' => 158,
'name' => 'Taranaki Region',
'iso2' => 'TKI'
],[
'country_id' => 158,
'name' => 'Nelson Region',
'iso2' => 'NSN'
],[
'country_id' => 158,
'name' => 'Southland Region',
'iso2' => 'STL'
],[
'country_id' => 158,
'name' => 'Auckland Region',
'iso2' => 'AUK'
],[
'country_id' => 158,
'name' => 'Tasman District',
'iso2' => 'TAS'
],[
'country_id' => 158,
'name' => 'Bay of Plenty Region',
'iso2' => 'BOP'
],[
'country_id' => 158,
'name' => 'Hawke\'s Bay Region',
'iso2' => 'HKB'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
