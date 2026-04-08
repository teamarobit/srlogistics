<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class SBStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 202,
'name' => 'Honiara',
'iso2' => 'CT'
],[
'country_id' => 202,
'name' => 'Temotu Province',
'iso2' => 'TE'
],[
'country_id' => 202,
'name' => 'Isabel Province',
'iso2' => 'IS'
],[
'country_id' => 202,
'name' => 'Choiseul Province',
'iso2' => 'CH'
],[
'country_id' => 202,
'name' => 'Makira-Ulawa Province',
'iso2' => 'MK'
],[
'country_id' => 202,
'name' => 'Malaita Province',
'iso2' => 'ML'
],[
'country_id' => 202,
'name' => 'Central Province',
'iso2' => 'CE'
],[
'country_id' => 202,
'name' => 'Guadalcanal Province',
'iso2' => 'GU'
],[
'country_id' => 202,
'name' => 'Western Province',
'iso2' => 'WE'
],[
'country_id' => 202,
'name' => 'Rennell and Bellona Province',
'iso2' => 'RB'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
