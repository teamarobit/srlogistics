<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class HRStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 55,
'name' => 'Požega-Slavonia',
'iso2' => '11'
],[
'country_id' => 55,
'name' => 'Split-Dalmatia',
'iso2' => '17'
],[
'country_id' => 55,
'name' => 'Međimurje',
'iso2' => '20'
],[
'country_id' => 55,
'name' => 'Zadar',
'iso2' => '13'
],[
'country_id' => 55,
'name' => 'Dubrovnik-Neretva',
'iso2' => '19'
],[
'country_id' => 55,
'name' => 'Krapina-Zagorje',
'iso2' => '02'
],[
'country_id' => 55,
'name' => 'Šibenik-Knin',
'iso2' => '15'
],[
'country_id' => 55,
'name' => 'Lika-Senj',
'iso2' => '09'
],[
'country_id' => 55,
'name' => 'Virovitica-Podravina',
'iso2' => '10'
],[
'country_id' => 55,
'name' => 'Sisak-Moslavina',
'iso2' => '03'
],[
'country_id' => 55,
'name' => 'Bjelovar-Bilogora',
'iso2' => '07'
],[
'country_id' => 55,
'name' => 'Primorje-Gorski Kotar',
'iso2' => '08'
],[
'country_id' => 55,
'name' => 'Zagreb',
'iso2' => '01'
],[
'country_id' => 55,
'name' => 'Brod-Posavina',
'iso2' => '12'
],[
'country_id' => 55,
'name' => 'Zagreb',
'iso2' => '21'
],[
'country_id' => 55,
'name' => 'Varaždin',
'iso2' => '05'
],[
'country_id' => 55,
'name' => 'Osijek-Baranja',
'iso2' => '14'
],[
'country_id' => 55,
'name' => 'Vukovar-Syrmia',
'iso2' => '16'
],[
'country_id' => 55,
'name' => 'Koprivnica-Križevci',
'iso2' => '06'
],[
'country_id' => 55,
'name' => 'Istria',
'iso2' => '18'
],[
'country_id' => 55,
'name' => 'Karlovac',
'iso2' => '04'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
