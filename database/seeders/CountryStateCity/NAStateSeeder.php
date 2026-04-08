<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class NAStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 152,
'name' => 'Kunene Region',
'iso2' => 'KU'
],[
'country_id' => 152,
'name' => 'Kavango West Region',
'iso2' => 'KW'
],[
'country_id' => 152,
'name' => 'Kavango East Region',
'iso2' => 'KE'
],[
'country_id' => 152,
'name' => 'Oshana Region',
'iso2' => 'ON'
],[
'country_id' => 152,
'name' => 'Hardap Region',
'iso2' => 'HA'
],[
'country_id' => 152,
'name' => 'Omusati Region',
'iso2' => 'OS'
],[
'country_id' => 152,
'name' => 'Ohangwena Region',
'iso2' => 'OW'
],[
'country_id' => 152,
'name' => 'Omaheke Region',
'iso2' => 'OH'
],[
'country_id' => 152,
'name' => 'Oshikoto Region',
'iso2' => 'OT'
],[
'country_id' => 152,
'name' => 'Erongo Region',
'iso2' => 'ER'
],[
'country_id' => 152,
'name' => 'Khomas Region',
'iso2' => 'KH'
],[
'country_id' => 152,
'name' => 'Karas Region',
'iso2' => 'KA'
],[
'country_id' => 152,
'name' => 'Otjozondjupa Region',
'iso2' => 'OD'
],[
'country_id' => 152,
'name' => 'Zambezi Region',
'iso2' => 'CA'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
