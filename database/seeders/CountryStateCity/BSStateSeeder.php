<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class BSStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 17,
'name' => 'Berry Islands',
'iso2' => 'BY'
],[
'country_id' => 17,
'name' => 'Nichollstown and Berry Islands',
'iso2' => 'NB'
],[
'country_id' => 17,
'name' => 'Green Turtle Cay',
'iso2' => 'GT'
],[
'country_id' => 17,
'name' => 'Central Eleuthera',
'iso2' => 'CE'
],[
'country_id' => 17,
'name' => 'Governors Harbour',
'iso2' => 'GH'
],[
'country_id' => 17,
'name' => 'High Rock',
'iso2' => 'HR'
],[
'country_id' => 17,
'name' => 'West Grand Bahama',
'iso2' => 'WG'
],[
'country_id' => 17,
'name' => 'Rum Cay District',
'iso2' => 'RC'
],[
'country_id' => 17,
'name' => 'Acklins',
'iso2' => 'AK'
],[
'country_id' => 17,
'name' => 'North Eleuthera',
'iso2' => 'NE'
],[
'country_id' => 17,
'name' => 'Central Abaco',
'iso2' => 'CO'
],[
'country_id' => 17,
'name' => 'Marsh Harbour',
'iso2' => 'MH'
],[
'country_id' => 17,
'name' => 'Black Point',
'iso2' => 'BP'
],[
'country_id' => 17,
'name' => 'Sandy Point',
'iso2' => 'SP'
],[
'country_id' => 17,
'name' => 'South Eleuthera',
'iso2' => 'SE'
],[
'country_id' => 17,
'name' => 'South Abaco',
'iso2' => 'SO'
],[
'country_id' => 17,
'name' => 'Inagua',
'iso2' => 'IN'
],[
'country_id' => 17,
'name' => 'Long Island',
'iso2' => 'LI'
],[
'country_id' => 17,
'name' => 'Cat Island',
'iso2' => 'CI'
],[
'country_id' => 17,
'name' => 'Exuma',
'iso2' => 'EX'
],[
'country_id' => 17,
'name' => 'Harbour Island',
'iso2' => 'HI'
],[
'country_id' => 17,
'name' => 'East Grand Bahama',
'iso2' => 'EG'
],[
'country_id' => 17,
'name' => 'Ragged Island',
'iso2' => 'RI'
],[
'country_id' => 17,
'name' => 'North Abaco',
'iso2' => 'NO'
],[
'country_id' => 17,
'name' => 'North Andros',
'iso2' => 'NS'
],[
'country_id' => 17,
'name' => 'Kemps Bay',
'iso2' => 'KB'
],[
'country_id' => 17,
'name' => 'Fresh Creek',
'iso2' => 'FC'
],[
'country_id' => 17,
'name' => 'San Salvador and Rum Cay',
'iso2' => 'SR'
],[
'country_id' => 17,
'name' => 'Crooked Island',
'iso2' => 'CK'
],[
'country_id' => 17,
'name' => 'South Andros',
'iso2' => 'SA'
],[
'country_id' => 17,
'name' => 'Rock Sound',
'iso2' => 'RS'
],[
'country_id' => 17,
'name' => 'Hope Town',
'iso2' => 'HT'
],[
'country_id' => 17,
'name' => 'Mangrove Cay',
'iso2' => 'MC'
],[
'country_id' => 17,
'name' => 'Freeport',
'iso2' => 'FP'
],[
'country_id' => 17,
'name' => 'San Salvador Island',
'iso2' => 'SS'
],[
'country_id' => 17,
'name' => 'Acklins and Crooked Islands',
'iso2' => 'AC'
],[
'country_id' => 17,
'name' => 'Bimini',
'iso2' => 'BI'
],[
'country_id' => 17,
'name' => 'Spanish Wells',
'iso2' => 'SW'
],[
'country_id' => 17,
'name' => 'Central Andros',
'iso2' => 'CS'
],[
'country_id' => 17,
'name' => 'Grand Cay',
'iso2' => 'GC'
],[
'country_id' => 17,
'name' => 'Mayaguana District',
'iso2' => 'MG'
],[
'country_id' => 17,
'name' => 'New Providence',
'iso2' => 'NP'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
