<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class NEStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 160,
'name' => 'Tillabéri Region',
'iso2' => '6'
],[
'country_id' => 160,
'name' => 'Dosso Region',
'iso2' => '3'
],[
'country_id' => 160,
'name' => 'Zinder Region',
'iso2' => '7'
],[
'country_id' => 160,
'name' => 'Maradi Region',
'iso2' => '4'
],[
'country_id' => 160,
'name' => 'Agadez Region',
'iso2' => '1'
],[
'country_id' => 160,
'name' => 'Diffa Region',
'iso2' => '2'
],[
'country_id' => 160,
'name' => 'Tahoua Region',
'iso2' => '5'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
