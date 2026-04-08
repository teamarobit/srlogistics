<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class LRStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 123,
'name' => 'Montserrado County',
'iso2' => 'MO'
],[
'country_id' => 123,
'name' => 'River Cess County',
'iso2' => 'RI'
],[
'country_id' => 123,
'name' => 'Bong County',
'iso2' => 'BG'
],[
'country_id' => 123,
'name' => 'Sinoe County',
'iso2' => 'SI'
],[
'country_id' => 123,
'name' => 'Grand Cape Mount County',
'iso2' => 'CM'
],[
'country_id' => 123,
'name' => 'Lofa County',
'iso2' => 'LO'
],[
'country_id' => 123,
'name' => 'River Gee County',
'iso2' => 'RG'
],[
'country_id' => 123,
'name' => 'Grand Gedeh County',
'iso2' => 'GG'
],[
'country_id' => 123,
'name' => 'Grand Bassa County',
'iso2' => 'GB'
],[
'country_id' => 123,
'name' => 'Bomi County',
'iso2' => 'BM'
],[
'country_id' => 123,
'name' => 'Maryland County',
'iso2' => 'MY'
],[
'country_id' => 123,
'name' => 'Margibi County',
'iso2' => 'MG'
],[
'country_id' => 123,
'name' => 'Gbarpolu County',
'iso2' => 'GP'
],[
'country_id' => 123,
'name' => 'Grand Kru County',
'iso2' => 'GK'
],[
'country_id' => 123,
'name' => 'Nimba',
'iso2' => 'NI'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
