<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class ILStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 106,
'name' => 'Northern District',
'iso2' => 'Z'
],[
'country_id' => 106,
'name' => 'Central District',
'iso2' => 'M'
],[
'country_id' => 106,
'name' => 'Southern District',
'iso2' => 'D'
],[
'country_id' => 106,
'name' => 'Haifa District',
'iso2' => 'HA'
],[
'country_id' => 106,
'name' => 'Jerusalem District',
'iso2' => 'JM'
],[
'country_id' => 106,
'name' => 'Tel Aviv District',
'iso2' => 'TA'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
