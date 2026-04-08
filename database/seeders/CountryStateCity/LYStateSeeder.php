<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class LYStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 124,
'name' => 'Murqub',
'iso2' => 'MB'
],[
'country_id' => 124,
'name' => 'Nuqat al Khams',
'iso2' => 'NQ'
],[
'country_id' => 124,
'name' => 'Zawiya District',
'iso2' => 'ZA'
],[
'country_id' => 124,
'name' => 'Al Wahat District',
'iso2' => 'WA'
],[
'country_id' => 124,
'name' => 'Sabha District',
'iso2' => 'SB'
],[
'country_id' => 124,
'name' => 'Derna District',
'iso2' => 'DR'
],[
'country_id' => 124,
'name' => 'Murzuq District',
'iso2' => 'MQ'
],[
'country_id' => 124,
'name' => 'Marj District',
'iso2' => 'MJ'
],[
'country_id' => 124,
'name' => 'Ghat District',
'iso2' => 'GT'
],[
'country_id' => 124,
'name' => 'Jufra',
'iso2' => 'JU'
],[
'country_id' => 124,
'name' => 'Tripoli District',
'iso2' => 'TB'
],[
'country_id' => 124,
'name' => 'Kufra District',
'iso2' => 'KF'
],[
'country_id' => 124,
'name' => 'Wadi al Hayaa District',
'iso2' => 'WD'
],[
'country_id' => 124,
'name' => 'Jabal al Gharbi District',
'iso2' => 'JG'
],[
'country_id' => 124,
'name' => 'Wadi al Shatii District',
'iso2' => 'WS'
],[
'country_id' => 124,
'name' => 'Nalut District',
'iso2' => 'NL'
],[
'country_id' => 124,
'name' => 'Sirte District',
'iso2' => 'SR'
],[
'country_id' => 124,
'name' => 'Misrata District',
'iso2' => 'MI'
],[
'country_id' => 124,
'name' => 'Jafara',
'iso2' => 'JI'
],[
'country_id' => 124,
'name' => 'Jabal al Akhdar',
'iso2' => 'JA'
],[
'country_id' => 124,
'name' => 'Benghazi',
'iso2' => 'BA'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
