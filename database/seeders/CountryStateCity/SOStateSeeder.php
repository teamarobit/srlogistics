<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class SOStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 203,
'name' => 'Hiran',
'iso2' => 'HI'
],[
'country_id' => 203,
'name' => 'Mudug',
'iso2' => 'MU'
],[
'country_id' => 203,
'name' => 'Bakool',
'iso2' => 'BK'
],[
'country_id' => 203,
'name' => 'Galguduud',
'iso2' => 'GA'
],[
'country_id' => 203,
'name' => 'Sanaag Region',
'iso2' => 'SA'
],[
'country_id' => 203,
'name' => 'Nugal',
'iso2' => 'NU'
],[
'country_id' => 203,
'name' => 'Lower Shebelle',
'iso2' => 'SH'
],[
'country_id' => 203,
'name' => 'Middle Juba',
'iso2' => 'JD'
],[
'country_id' => 203,
'name' => 'Middle Shebelle',
'iso2' => 'SD'
],[
'country_id' => 203,
'name' => 'Lower Juba',
'iso2' => 'JH'
],[
'country_id' => 203,
'name' => 'Awdal Region',
'iso2' => 'AW'
],[
'country_id' => 203,
'name' => 'Bay',
'iso2' => 'BY'
],[
'country_id' => 203,
'name' => 'Banaadir',
'iso2' => 'BN'
],[
'country_id' => 203,
'name' => 'Gedo',
'iso2' => 'GE'
],[
'country_id' => 203,
'name' => 'Togdheer Region',
'iso2' => 'TO'
],[
'country_id' => 203,
'name' => 'Bari',
'iso2' => 'BR'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
