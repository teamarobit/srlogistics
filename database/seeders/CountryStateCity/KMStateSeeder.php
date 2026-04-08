<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class KMStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 49,
'name' => 'Mohéli',
'iso2' => 'M'
],[
'country_id' => 49,
'name' => 'Anjouan',
'iso2' => 'A'
],[
'country_id' => 49,
'name' => 'Grande Comore',
'iso2' => 'G'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
