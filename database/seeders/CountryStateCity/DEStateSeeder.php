<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class DEStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 82,
'name' => 'Schleswig-Holstein',
'iso2' => 'SH'
],[
'country_id' => 82,
'name' => 'Baden-Württemberg',
'iso2' => 'BW'
],[
'country_id' => 82,
'name' => 'Mecklenburg-Vorpommern',
'iso2' => 'MV'
],[
'country_id' => 82,
'name' => 'Lower Saxony',
'iso2' => 'NI'
],[
'country_id' => 82,
'name' => 'Bavaria',
'iso2' => 'BY'
],[
'country_id' => 82,
'name' => 'Berlin',
'iso2' => 'BE'
],[
'country_id' => 82,
'name' => 'Saxony-Anhalt',
'iso2' => 'ST'
],[
'country_id' => 82,
'name' => 'Brandenburg',
'iso2' => 'BB'
],[
'country_id' => 82,
'name' => 'Bremen',
'iso2' => 'HB'
],[
'country_id' => 82,
'name' => 'Thuringia',
'iso2' => 'TH'
],[
'country_id' => 82,
'name' => 'Hamburg',
'iso2' => 'HH'
],[
'country_id' => 82,
'name' => 'North Rhine-Westphalia',
'iso2' => 'NW'
],[
'country_id' => 82,
'name' => 'Hesse',
'iso2' => 'HE'
],[
'country_id' => 82,
'name' => 'Rhineland-Palatinate',
'iso2' => 'RP'
],[
'country_id' => 82,
'name' => 'Saarland',
'iso2' => 'SL'
],[
'country_id' => 82,
'name' => 'Saxony',
'iso2' => 'SN'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
