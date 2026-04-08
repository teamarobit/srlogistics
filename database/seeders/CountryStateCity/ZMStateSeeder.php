<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class ZMStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 246,
'name' => 'Northern Province',
'iso2' => '05'
],[
'country_id' => 246,
'name' => 'Western Province',
'iso2' => '01'
],[
'country_id' => 246,
'name' => 'Copperbelt Province',
'iso2' => '08'
],[
'country_id' => 246,
'name' => 'Northwestern Province',
'iso2' => '06'
],[
'country_id' => 246,
'name' => 'Central Province',
'iso2' => '02'
],[
'country_id' => 246,
'name' => 'Luapula Province',
'iso2' => '04'
],[
'country_id' => 246,
'name' => 'Lusaka Province',
'iso2' => '09'
],[
'country_id' => 246,
'name' => 'Muchinga Province',
'iso2' => '10'
],[
'country_id' => 246,
'name' => 'Southern Province',
'iso2' => '07'
],[
'country_id' => 246,
'name' => 'Eastern Province',
'iso2' => '03'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
