<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class CHStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 214,
'name' => 'Aargau',
'iso2' => 'AG'
],[
'country_id' => 214,
'name' => 'Fribourg',
'iso2' => 'FR'
],[
'country_id' => 214,
'name' => 'Basel-Land',
'iso2' => 'BL'
],[
'country_id' => 214,
'name' => 'Uri',
'iso2' => 'UR'
],[
'country_id' => 214,
'name' => 'Ticino',
'iso2' => 'TI'
],[
'country_id' => 214,
'name' => 'St. Gallen',
'iso2' => 'SG'
],[
'country_id' => 214,
'name' => 'Bern',
'iso2' => 'BE'
],[
'country_id' => 214,
'name' => 'Zug',
'iso2' => 'ZG'
],[
'country_id' => 214,
'name' => 'Geneva',
'iso2' => 'GE'
],[
'country_id' => 214,
'name' => 'Valais',
'iso2' => 'VS'
],[
'country_id' => 214,
'name' => 'Appenzell Innerrhoden',
'iso2' => 'AI'
],[
'country_id' => 214,
'name' => 'Obwalden',
'iso2' => 'OW'
],[
'country_id' => 214,
'name' => 'Vaud',
'iso2' => 'VD'
],[
'country_id' => 214,
'name' => 'Nidwalden',
'iso2' => 'NW'
],[
'country_id' => 214,
'name' => 'Schwyz',
'iso2' => 'SZ'
],[
'country_id' => 214,
'name' => 'Schaffhausen',
'iso2' => 'SH'
],[
'country_id' => 214,
'name' => 'Appenzell Ausserrhoden',
'iso2' => 'AR'
],[
'country_id' => 214,
'name' => 'Zürich',
'iso2' => 'ZH'
],[
'country_id' => 214,
'name' => 'Thurgau',
'iso2' => 'TG'
],[
'country_id' => 214,
'name' => 'Jura',
'iso2' => 'JU'
],[
'country_id' => 214,
'name' => 'Neuchâtel',
'iso2' => 'NE'
],[
'country_id' => 214,
'name' => 'Graubünden',
'iso2' => 'GR'
],[
'country_id' => 214,
'name' => 'Glarus',
'iso2' => 'GL'
],[
'country_id' => 214,
'name' => 'Solothurn',
'iso2' => 'SO'
],[
'country_id' => 214,
'name' => 'Lucerne',
'iso2' => 'LU'
],[
'country_id' => 214,
'name' => 'Basel-Stadt',
'iso2' => 'BS'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
