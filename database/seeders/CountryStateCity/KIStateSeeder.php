<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class KIStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 114,
'name' => 'Phoenix Islands',
'iso2' => 'P'
],[
'country_id' => 114,
'name' => 'Gilbert Islands',
'iso2' => 'G'
],[
'country_id' => 114,
'name' => 'Line Islands',
'iso2' => 'L'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
