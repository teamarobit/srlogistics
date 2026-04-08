<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class JOStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 111,
'name' => 'Karak',
'iso2' => 'KA'
],[
'country_id' => 111,
'name' => 'Tafilah',
'iso2' => 'AT'
],[
'country_id' => 111,
'name' => 'Madaba',
'iso2' => 'MD'
],[
'country_id' => 111,
'name' => 'Aqaba',
'iso2' => 'AQ'
],[
'country_id' => 111,
'name' => 'Irbid',
'iso2' => 'IR'
],[
'country_id' => 111,
'name' => 'Balqa',
'iso2' => 'BA'
],[
'country_id' => 111,
'name' => 'Mafraq',
'iso2' => 'MA'
],[
'country_id' => 111,
'name' => 'Ajloun',
'iso2' => 'AJ'
],[
'country_id' => 111,
'name' => 'Ma\'an',
'iso2' => 'MN'
],[
'country_id' => 111,
'name' => 'Amman',
'iso2' => 'AM'
],[
'country_id' => 111,
'name' => 'Jerash',
'iso2' => 'JA'
],[
'country_id' => 111,
'name' => 'Zarqa',
'iso2' => 'AZ'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
