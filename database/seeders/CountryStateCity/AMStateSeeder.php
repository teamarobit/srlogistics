<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class AMStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 12,
'name' => 'Aragatsotn Region',
'iso2' => 'AG'
],[
'country_id' => 12,
'name' => 'Ararat Province',
'iso2' => 'AR'
],[
'country_id' => 12,
'name' => 'Vayots Dzor Region',
'iso2' => 'VD'
],[
'country_id' => 12,
'name' => 'Armavir Region',
'iso2' => 'AV'
],[
'country_id' => 12,
'name' => 'Syunik Province',
'iso2' => 'SU'
],[
'country_id' => 12,
'name' => 'Gegharkunik Province',
'iso2' => 'GR'
],[
'country_id' => 12,
'name' => 'Lori Region',
'iso2' => 'LO'
],[
'country_id' => 12,
'name' => 'Yerevan',
'iso2' => 'ER'
],[
'country_id' => 12,
'name' => 'Shirak Region',
'iso2' => 'SH'
],[
'country_id' => 12,
'name' => 'Tavush Region',
'iso2' => 'TV'
],[
'country_id' => 12,
'name' => 'Kotayk Region',
'iso2' => 'KT'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
