<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class NLStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 156,
'name' => 'Utrecht',
'iso2' => 'UT'
],[
'country_id' => 156,
'name' => 'Gelderland',
'iso2' => 'GE'
],[
'country_id' => 156,
'name' => 'North Holland',
'iso2' => 'NH'
],[
'country_id' => 156,
'name' => 'Drenthe',
'iso2' => 'DR'
],[
'country_id' => 156,
'name' => 'South Holland',
'iso2' => 'ZH'
],[
'country_id' => 156,
'name' => 'Limburg',
'iso2' => 'LI'
],[
'country_id' => 156,
'name' => 'Sint Eustatius',
'iso2' => 'BQ3'
],[
'country_id' => 156,
'name' => 'Groningen',
'iso2' => 'GR'
],[
'country_id' => 156,
'name' => 'Overijssel',
'iso2' => 'OV'
],[
'country_id' => 156,
'name' => 'Flevoland',
'iso2' => 'FL'
],[
'country_id' => 156,
'name' => 'Zeeland',
'iso2' => 'ZE'
],[
'country_id' => 156,
'name' => 'Saba',
'iso2' => 'BQ2'
],[
'country_id' => 156,
'name' => 'Friesland',
'iso2' => 'FR'
],[
'country_id' => 156,
'name' => 'North Brabant',
'iso2' => 'NB'
],[
'country_id' => 156,
'name' => 'Bonaire',
'iso2' => 'BQ1'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
