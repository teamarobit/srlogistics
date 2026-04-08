<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class UMStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 234,
'name' => 'Baker Island',
'iso2' => '81'
],[
'country_id' => 234,
'name' => 'Howland Island',
'iso2' => '84'
],[
'country_id' => 234,
'name' => 'Jarvis Island',
'iso2' => '86'
],[
'country_id' => 234,
'name' => 'Johnston Atoll',
'iso2' => '67'
],[
'country_id' => 234,
'name' => 'Kingman Reef',
'iso2' => '89'
],[
'country_id' => 234,
'name' => 'Midway Islands',
'iso2' => '71'
],[
'country_id' => 234,
'name' => 'Navassa Island',
'iso2' => '76'
],[
'country_id' => 234,
'name' => 'Palmyra Atoll',
'iso2' => '95'
],[
'country_id' => 234,
'name' => 'Wake Island',
'iso2' => '79'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
