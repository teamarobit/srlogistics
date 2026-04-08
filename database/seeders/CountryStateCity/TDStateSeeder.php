<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class TDStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 43,
'name' => 'Moyen-Chari',
'iso2' => 'MC'
],[
'country_id' => 43,
'name' => 'Mayo-Kebbi Ouest',
'iso2' => 'MO'
],[
'country_id' => 43,
'name' => 'Sila',
'iso2' => 'SI'
],[
'country_id' => 43,
'name' => 'Hadjer-Lamis',
'iso2' => 'HL'
],[
'country_id' => 43,
'name' => 'Borkou',
'iso2' => 'BO'
],[
'country_id' => 43,
'name' => 'Ennedi-Est',
'iso2' => 'EE'
],[
'country_id' => 43,
'name' => 'Guéra',
'iso2' => 'GR'
],[
'country_id' => 43,
'name' => 'Lac',
'iso2' => 'LC'
],[
'country_id' => 43,
'name' => 'Tandjilé',
'iso2' => 'TA'
],[
'country_id' => 43,
'name' => 'Mayo-Kebbi Est',
'iso2' => 'ME'
],[
'country_id' => 43,
'name' => 'Wadi Fira',
'iso2' => 'WF'
],[
'country_id' => 43,
'name' => 'Ouaddaï',
'iso2' => 'OD'
],[
'country_id' => 43,
'name' => 'Bahr el Gazel',
'iso2' => 'BG'
],[
'country_id' => 43,
'name' => 'Ennedi-Ouest',
'iso2' => 'EO'
],[
'country_id' => 43,
'name' => 'Logone Occidental',
'iso2' => 'LO'
],[
'country_id' => 43,
'name' => 'N Djamena',
'iso2' => 'ND'
],[
'country_id' => 43,
'name' => 'Tibesti',
'iso2' => 'TI'
],[
'country_id' => 43,
'name' => 'Kanem',
'iso2' => 'KA'
],[
'country_id' => 43,
'name' => 'Mandoul',
'iso2' => 'MA'
],[
'country_id' => 43,
'name' => 'Batha',
'iso2' => 'BA'
],[
'country_id' => 43,
'name' => 'Logone Oriental',
'iso2' => 'LR'
],[
'country_id' => 43,
'name' => 'Salamat',
'iso2' => 'SA'
],[
'country_id' => 43,
'name' => 'Chari-Baguirmi',
'iso2' => 'CB'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
