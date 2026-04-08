<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class IQStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 104,
'name' => 'Dhi Qar',
'iso2' => 'DQ'
],[
'country_id' => 104,
'name' => 'Babylon',
'iso2' => 'BB'
],[
'country_id' => 104,
'name' => 'Al-Qādisiyyah',
'iso2' => 'QA'
],[
'country_id' => 104,
'name' => 'Karbala',
'iso2' => 'KA'
],[
'country_id' => 104,
'name' => 'Al Muthanna',
'iso2' => 'MU'
],[
'country_id' => 104,
'name' => 'Baghdad',
'iso2' => 'BG'
],[
'country_id' => 104,
'name' => 'Basra',
'iso2' => 'BA'
],[
'country_id' => 104,
'name' => 'Saladin',
'iso2' => 'SD'
],[
'country_id' => 104,
'name' => 'Najaf',
'iso2' => 'NA'
],[
'country_id' => 104,
'name' => 'Nineveh',
'iso2' => 'NI'
],[
'country_id' => 104,
'name' => 'Al Anbar',
'iso2' => 'AN'
],[
'country_id' => 104,
'name' => 'Diyala',
'iso2' => 'DI'
],[
'country_id' => 104,
'name' => 'Maysan',
'iso2' => 'MA'
],[
'country_id' => 104,
'name' => 'Dohuk',
'iso2' => 'DA'
],[
'country_id' => 104,
'name' => 'Erbil',
'iso2' => 'AR'
],[
'country_id' => 104,
'name' => 'Sulaymaniyah',
'iso2' => 'SU'
],[
'country_id' => 104,
'name' => 'Wasit',
'iso2' => 'WA'
],[
'country_id' => 104,
'name' => 'Kirkuk',
'iso2' => 'KI'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
