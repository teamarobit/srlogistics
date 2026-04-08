<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class PWStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 168,
'name' => 'Peleliu',
'iso2' => '350'
],[
'country_id' => 168,
'name' => 'Ngardmau',
'iso2' => '222'
],[
'country_id' => 168,
'name' => 'Airai',
'iso2' => '004'
],[
'country_id' => 168,
'name' => 'Hatohobei',
'iso2' => '050'
],[
'country_id' => 168,
'name' => 'Melekeok',
'iso2' => '212'
],[
'country_id' => 168,
'name' => 'Ngatpang',
'iso2' => '224'
],[
'country_id' => 168,
'name' => 'Koror',
'iso2' => '150'
],[
'country_id' => 168,
'name' => 'Ngarchelong',
'iso2' => '218'
],[
'country_id' => 168,
'name' => 'Ngiwal',
'iso2' => '228'
],[
'country_id' => 168,
'name' => 'Sonsorol',
'iso2' => '370'
],[
'country_id' => 168,
'name' => 'Ngchesar',
'iso2' => '226'
],[
'country_id' => 168,
'name' => 'Ngaraard',
'iso2' => '214'
],[
'country_id' => 168,
'name' => 'Angaur',
'iso2' => '010'
],[
'country_id' => 168,
'name' => 'Kayangel',
'iso2' => '100'
],[
'country_id' => 168,
'name' => 'Aimeliik',
'iso2' => '002'
],[
'country_id' => 168,
'name' => 'Ngeremlengui',
'iso2' => '227'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
