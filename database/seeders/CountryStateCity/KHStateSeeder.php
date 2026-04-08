<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class KHStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 37,
'name' => 'Svay Rieng',
'iso2' => '20'
],[
'country_id' => 37,
'name' => 'Preah Vihear',
'iso2' => '13'
],[
'country_id' => 37,
'name' => 'Prey Veng',
'iso2' => '14'
],[
'country_id' => 37,
'name' => 'Takeo',
'iso2' => '21'
],[
'country_id' => 37,
'name' => 'Battambang',
'iso2' => '2'
],[
'country_id' => 37,
'name' => 'Pursat',
'iso2' => '15'
],[
'country_id' => 37,
'name' => 'Kep',
'iso2' => '23'
],[
'country_id' => 37,
'name' => 'Kampong Chhnang',
'iso2' => '4'
],[
'country_id' => 37,
'name' => 'Pailin',
'iso2' => '24'
],[
'country_id' => 37,
'name' => 'Kampot',
'iso2' => '7'
],[
'country_id' => 37,
'name' => 'Koh Kong',
'iso2' => '9'
],[
'country_id' => 37,
'name' => 'Kandal',
'iso2' => '8'
],[
'country_id' => 37,
'name' => 'Banteay Meanchey',
'iso2' => '1'
],[
'country_id' => 37,
'name' => 'Mondulkiri',
'iso2' => '11'
],[
'country_id' => 37,
'name' => 'Kratie',
'iso2' => '10'
],[
'country_id' => 37,
'name' => 'Oddar Meanchey',
'iso2' => '22'
],[
'country_id' => 37,
'name' => 'Kampong Speu',
'iso2' => '5'
],[
'country_id' => 37,
'name' => 'Sihanoukville',
'iso2' => '18'
],[
'country_id' => 37,
'name' => 'Ratanakiri',
'iso2' => '16'
],[
'country_id' => 37,
'name' => 'Kampong Cham',
'iso2' => '3'
],[
'country_id' => 37,
'name' => 'Siem Reap',
'iso2' => '17'
],[
'country_id' => 37,
'name' => 'Stung Treng',
'iso2' => '19'
],[
'country_id' => 37,
'name' => 'Phnom Penh',
'iso2' => '12'
],[
'country_id' => 37,
'name' => 'Tai Po District',
'iso2' => 'NTP'
],[
'country_id' => 37,
'name' => 'Kampong Thom',
'iso2' => '6'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
