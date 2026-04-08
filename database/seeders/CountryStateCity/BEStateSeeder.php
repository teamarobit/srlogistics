<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class BEStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 22,
'name' => 'Limburg',
'iso2' => 'VLI'
],[
'country_id' => 22,
'name' => 'Flanders',
'iso2' => 'VLG'
],[
'country_id' => 22,
'name' => 'Flemish Brabant',
'iso2' => 'VBR'
],[
'country_id' => 22,
'name' => 'Hainaut',
'iso2' => 'WHT'
],[
'country_id' => 22,
'name' => 'Brussels-Capital Region',
'iso2' => 'BRU'
],[
'country_id' => 22,
'name' => 'East Flanders',
'iso2' => 'VOV'
],[
'country_id' => 22,
'name' => 'Namur',
'iso2' => 'WNA'
],[
'country_id' => 22,
'name' => 'Luxembourg',
'iso2' => 'WLX'
],[
'country_id' => 22,
'name' => 'Wallonia',
'iso2' => 'WAL'
],[
'country_id' => 22,
'name' => 'Antwerp',
'iso2' => 'VAN'
],[
'country_id' => 22,
'name' => 'Walloon Brabant',
'iso2' => 'WBR'
],[
'country_id' => 22,
'name' => 'West Flanders',
'iso2' => 'VWV'
],[
'country_id' => 22,
'name' => 'Liège',
'iso2' => 'WLG'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
