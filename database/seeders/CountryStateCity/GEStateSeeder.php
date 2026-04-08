<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class GEStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 81,
'name' => 'Khelvachauri Municipality',
'iso2' => '29'
],[
'country_id' => 81,
'name' => 'Senaki Municipality',
'iso2' => '50'
],[
'country_id' => 81,
'name' => 'Tbilisi',
'iso2' => 'TB'
],[
'country_id' => 81,
'name' => 'Adjara',
'iso2' => 'AJ'
],[
'country_id' => 81,
'name' => 'Autonomous Republic of Abkhazia',
'iso2' => 'AB'
],[
'country_id' => 81,
'name' => 'Mtskheta-Mtianeti',
'iso2' => 'MM'
],[
'country_id' => 81,
'name' => 'Shida Kartli',
'iso2' => 'SK'
],[
'country_id' => 81,
'name' => 'Kvemo Kartli',
'iso2' => 'KK'
],[
'country_id' => 81,
'name' => 'Imereti',
'iso2' => 'IM'
],[
'country_id' => 81,
'name' => 'Samtskhe-Javakheti',
'iso2' => 'SJ'
],[
'country_id' => 81,
'name' => 'Guria',
'iso2' => 'GU'
],[
'country_id' => 81,
'name' => 'Samegrelo-Zemo Svaneti',
'iso2' => 'SZ'
],[
'country_id' => 81,
'name' => 'Racha-Lechkhumi and Kvemo Svaneti',
'iso2' => 'RL'
],[
'country_id' => 81,
'name' => 'Kakheti',
'iso2' => 'KA'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
