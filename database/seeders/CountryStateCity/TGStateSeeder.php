<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class TGStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 220,
'name' => 'Centrale Region',
'iso2' => 'C'
],[
'country_id' => 220,
'name' => 'Maritime',
'iso2' => 'M'
],[
'country_id' => 220,
'name' => 'Plateaux Region',
'iso2' => 'P'
],[
'country_id' => 220,
'name' => 'Savanes Region',
'iso2' => 'S'
],[
'country_id' => 220,
'name' => 'Kara Region',
'iso2' => 'K'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
