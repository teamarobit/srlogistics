<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class TJStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 217,
'name' => 'districts of Republican Subordination',
'iso2' => 'RA'
],[
'country_id' => 217,
'name' => 'Khatlon Province',
'iso2' => 'KT'
],[
'country_id' => 217,
'name' => 'Gorno-Badakhshan Autonomous Province',
'iso2' => 'GB'
],[
'country_id' => 217,
'name' => 'Sughd Province',
'iso2' => 'SU'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
