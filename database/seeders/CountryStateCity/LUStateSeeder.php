<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class LUStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 127,
'name' => 'Canton of Diekirch',
'iso2' => 'DI'
],[
'country_id' => 127,
'name' => 'Luxembourg District',
'iso2' => 'L'
],[
'country_id' => 127,
'name' => 'Canton of Echternach',
'iso2' => 'EC'
],[
'country_id' => 127,
'name' => 'Canton of Redange',
'iso2' => 'RD'
],[
'country_id' => 127,
'name' => 'Canton of Esch-sur-Alzette',
'iso2' => 'ES'
],[
'country_id' => 127,
'name' => 'Canton of Capellen',
'iso2' => 'CA'
],[
'country_id' => 127,
'name' => 'Canton of Remich',
'iso2' => 'RM'
],[
'country_id' => 127,
'name' => 'Grevenmacher District',
'iso2' => 'G'
],[
'country_id' => 127,
'name' => 'Canton of Clervaux',
'iso2' => 'CL'
],[
'country_id' => 127,
'name' => 'Canton of Mersch',
'iso2' => 'ME'
],[
'country_id' => 127,
'name' => 'Canton of Vianden',
'iso2' => 'VD'
],[
'country_id' => 127,
'name' => 'Diekirch District',
'iso2' => 'D'
],[
'country_id' => 127,
'name' => 'Canton of Grevenmacher',
'iso2' => 'GR'
],[
'country_id' => 127,
'name' => 'Canton of Wiltz',
'iso2' => 'WI'
],[
'country_id' => 127,
'name' => 'Canton of Luxembourg',
'iso2' => 'LU'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
