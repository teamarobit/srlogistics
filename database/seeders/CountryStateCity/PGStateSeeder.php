<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class PGStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 171,
'name' => 'West New Britain Province',
'iso2' => 'WBK'
],[
'country_id' => 171,
'name' => 'Bougainville',
'iso2' => 'NSB'
],[
'country_id' => 171,
'name' => 'Jiwaka Province',
'iso2' => 'JWK'
],[
'country_id' => 171,
'name' => 'Hela',
'iso2' => 'HLA'
],[
'country_id' => 171,
'name' => 'East New Britain',
'iso2' => 'EBR'
],[
'country_id' => 171,
'name' => 'Morobe Province',
'iso2' => 'MPL'
],[
'country_id' => 171,
'name' => 'Sandaun Province',
'iso2' => 'SAN'
],[
'country_id' => 171,
'name' => 'Port Moresby',
'iso2' => 'NCD'
],[
'country_id' => 171,
'name' => 'Oro Province',
'iso2' => 'NPP'
],[
'country_id' => 171,
'name' => 'Gulf',
'iso2' => 'GPK'
],[
'country_id' => 171,
'name' => 'Western Highlands Province',
'iso2' => 'WHM'
],[
'country_id' => 171,
'name' => 'New Ireland Province',
'iso2' => 'NIK'
],[
'country_id' => 171,
'name' => 'Manus Province',
'iso2' => 'MRL'
],[
'country_id' => 171,
'name' => 'Madang Province',
'iso2' => 'MPM'
],[
'country_id' => 171,
'name' => 'Southern Highlands Province',
'iso2' => 'SHM'
],[
'country_id' => 171,
'name' => 'Eastern Highlands Province',
'iso2' => 'EHG'
],[
'country_id' => 171,
'name' => 'Chimbu Province',
'iso2' => 'CPK'
],[
'country_id' => 171,
'name' => 'Central Province',
'iso2' => 'CPM'
],[
'country_id' => 171,
'name' => 'Enga Province',
'iso2' => 'EPW'
],[
'country_id' => 171,
'name' => 'Milne Bay Province',
'iso2' => 'MBA'
],[
'country_id' => 171,
'name' => 'Western Province',
'iso2' => 'WPD'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
