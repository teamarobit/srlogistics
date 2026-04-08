<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class BHStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 18,
'name' => 'Capital',
'iso2' => '13'
],[
'country_id' => 18,
'name' => 'Southern',
'iso2' => '14'
],[
'country_id' => 18,
'name' => 'Northern',
'iso2' => '17'
],[
'country_id' => 18,
'name' => 'Muharraq',
'iso2' => '15'
],[
'country_id' => 18,
'name' => 'Central',
'iso2' => '16'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
