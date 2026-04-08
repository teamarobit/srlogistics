<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class SYStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 215,
'name' => 'Hama',
'iso2' => 'HM'
],[
'country_id' => 215,
'name' => 'Rif Dimashq',
'iso2' => 'RD'
],[
'country_id' => 215,
'name' => 'As-Suwayda',
'iso2' => 'SU'
],[
'country_id' => 215,
'name' => 'Deir ez-Zor',
'iso2' => 'DY'
],[
'country_id' => 215,
'name' => 'Latakia',
'iso2' => 'LA'
],[
'country_id' => 215,
'name' => 'Damascus',
'iso2' => 'DI'
],[
'country_id' => 215,
'name' => 'Idlib',
'iso2' => 'ID'
],[
'country_id' => 215,
'name' => 'Al-Hasakah',
'iso2' => 'HA'
],[
'country_id' => 215,
'name' => 'Homs',
'iso2' => 'HI'
],[
'country_id' => 215,
'name' => 'Quneitra',
'iso2' => 'QU'
],[
'country_id' => 215,
'name' => 'Al-Raqqah',
'iso2' => 'RA'
],[
'country_id' => 215,
'name' => 'Daraa',
'iso2' => 'DR'
],[
'country_id' => 215,
'name' => 'Aleppo',
'iso2' => 'HL'
],[
'country_id' => 215,
'name' => 'Tartus',
'iso2' => 'TA'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
