<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class TTStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 223,
'name' => 'Western Tobago',
'iso2' => 'WTO'
],[
'country_id' => 223,
'name' => 'Couva-Tabaquite-Talparo Regional Corporation',
'iso2' => 'CTT'
],[
'country_id' => 223,
'name' => 'Eastern Tobago',
'iso2' => 'ETO'
],[
'country_id' => 223,
'name' => 'Rio Claro-Mayaro Regional Corporation',
'iso2' => 'MRC'
],[
'country_id' => 223,
'name' => 'San Juan-Laventille Regional Corporation',
'iso2' => 'SJL'
],[
'country_id' => 223,
'name' => 'Tunapuna-Piarco Regional Corporation',
'iso2' => 'TUP'
],[
'country_id' => 223,
'name' => 'San Fernando',
'iso2' => 'SFO'
],[
'country_id' => 223,
'name' => 'Point Fortin',
'iso2' => 'PTF'
],[
'country_id' => 223,
'name' => 'Sangre Grande Regional Corporation',
'iso2' => 'SGE'
],[
'country_id' => 223,
'name' => 'Arima',
'iso2' => 'ARI'
],[
'country_id' => 223,
'name' => 'Port of Spain',
'iso2' => 'POS'
],[
'country_id' => 223,
'name' => 'Siparia Regional Corporation',
'iso2' => 'SIP'
],[
'country_id' => 223,
'name' => 'Penal-Debe Regional Corporation',
'iso2' => 'PED'
],[
'country_id' => 223,
'name' => 'Chaguanas',
'iso2' => 'CHA'
],[
'country_id' => 223,
'name' => 'Diego Martin Regional Corporation',
'iso2' => 'DMN'
],[
'country_id' => 223,
'name' => 'Princes Town Regional Corporation',
'iso2' => 'PRT'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
