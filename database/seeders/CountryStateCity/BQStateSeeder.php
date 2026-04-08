<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class BQStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 155,
'name' => 'Bonaire',
'iso2' => 'BQ1'
],[
'country_id' => 155,
'name' => 'Saba',
'iso2' => 'BQ2'
],[
'country_id' => 155,
'name' => 'Sint Eustatius',
'iso2' => 'BQ3'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
