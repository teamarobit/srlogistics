<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class TMStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 226,
'name' => 'Mary Region',
'iso2' => 'M'
],[
'country_id' => 226,
'name' => 'Lebap Region',
'iso2' => 'L'
],[
'country_id' => 226,
'name' => 'Ashgabat',
'iso2' => 'S'
],[
'country_id' => 226,
'name' => 'Balkan Region',
'iso2' => 'B'
],[
'country_id' => 226,
'name' => 'Daşoguz Region',
'iso2' => 'D'
],[
'country_id' => 226,
'name' => 'Ahal Region',
'iso2' => 'A'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
