<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class KZStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 112,
'name' => 'Mangystau Region',
'iso2' => 'MAN'
],[
'country_id' => 112,
'name' => 'Kyzylorda Region',
'iso2' => 'KZY'
],[
'country_id' => 112,
'name' => 'Almaty Region',
'iso2' => 'ALM'
],[
'country_id' => 112,
'name' => 'North Kazakhstan Region',
'iso2' => 'SEV'
],[
'country_id' => 112,
'name' => 'Akmola Region',
'iso2' => 'AKM'
],[
'country_id' => 112,
'name' => 'Pavlodar Region',
'iso2' => 'PAV'
],[
'country_id' => 112,
'name' => 'Jambyl Region',
'iso2' => 'ZHA'
],[
'country_id' => 112,
'name' => 'West Kazakhstan Province',
'iso2' => 'ZAP'
],[
'country_id' => 112,
'name' => 'Turkestan Region',
'iso2' => 'YUZ'
],[
'country_id' => 112,
'name' => 'Karaganda Region',
'iso2' => 'KAR'
],[
'country_id' => 112,
'name' => 'Aktobe Region',
'iso2' => 'AKT'
],[
'country_id' => 112,
'name' => 'Almaty',
'iso2' => 'ALA'
],[
'country_id' => 112,
'name' => 'Atyrau Region',
'iso2' => 'ATY'
],[
'country_id' => 112,
'name' => 'East Kazakhstan Region',
'iso2' => 'VOS'
],[
'country_id' => 112,
'name' => 'Baikonur',
'iso2' => 'BAY'
],[
'country_id' => 112,
'name' => 'Nur-Sultan',
'iso2' => 'AST'
],[
'country_id' => 112,
'name' => 'Kostanay Region',
'iso2' => 'KUS'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
