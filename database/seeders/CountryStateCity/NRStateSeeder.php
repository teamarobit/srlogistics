<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class NRStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 153,
'name' => 'Ewa District',
'iso2' => '09'
],[
'country_id' => 153,
'name' => 'Uaboe District',
'iso2' => '13'
],[
'country_id' => 153,
'name' => 'Aiwo District',
'iso2' => '01'
],[
'country_id' => 153,
'name' => 'Meneng District',
'iso2' => '11'
],[
'country_id' => 153,
'name' => 'Anabar District',
'iso2' => '02'
],[
'country_id' => 153,
'name' => 'Nibok District',
'iso2' => '12'
],[
'country_id' => 153,
'name' => 'Baiti District',
'iso2' => '05'
],[
'country_id' => 153,
'name' => 'Ijuw District',
'iso2' => '10'
],[
'country_id' => 153,
'name' => 'Buada District',
'iso2' => '07'
],[
'country_id' => 153,
'name' => 'Anibare District',
'iso2' => '04'
],[
'country_id' => 153,
'name' => 'Yaren District',
'iso2' => '14'
],[
'country_id' => 153,
'name' => 'Boe District',
'iso2' => '06'
],[
'country_id' => 153,
'name' => 'Denigomodu District',
'iso2' => '08'
],[
'country_id' => 153,
'name' => 'Anetan District',
'iso2' => '03'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
