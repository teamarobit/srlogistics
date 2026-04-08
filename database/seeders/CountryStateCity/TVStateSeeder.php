<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class TVStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 228,
'name' => 'Niutao Island Council',
'iso2' => 'NIT'
],[
'country_id' => 228,
'name' => 'Nanumanga',
'iso2' => 'NMG'
],[
'country_id' => 228,
'name' => 'Nui',
'iso2' => 'NUI'
],[
'country_id' => 228,
'name' => 'Nanumea',
'iso2' => 'NMA'
],[
'country_id' => 228,
'name' => 'Vaitupu',
'iso2' => 'VAI'
],[
'country_id' => 228,
'name' => 'Funafuti',
'iso2' => 'FUN'
],[
'country_id' => 228,
'name' => 'Nukufetau',
'iso2' => 'NKF'
],[
'country_id' => 228,
'name' => 'Nukulaelae',
'iso2' => 'NKL'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
