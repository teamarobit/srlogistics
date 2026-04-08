<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class STStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 193,
'name' => 'Príncipe Province',
'iso2' => 'P'
],[
'country_id' => 193,
'name' => 'São Tomé Province',
'iso2' => 'S'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
