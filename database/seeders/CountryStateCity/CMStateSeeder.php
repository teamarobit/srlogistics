<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class CMStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 38,
'name' => 'Far North',
'iso2' => 'EN'
],[
'country_id' => 38,
'name' => 'Northwest',
'iso2' => 'NW'
],[
'country_id' => 38,
'name' => 'Southwest',
'iso2' => 'SW'
],[
'country_id' => 38,
'name' => 'South',
'iso2' => 'SU'
],[
'country_id' => 38,
'name' => 'Centre',
'iso2' => 'CE'
],[
'country_id' => 38,
'name' => 'East',
'iso2' => 'ES'
],[
'country_id' => 38,
'name' => 'Littoral',
'iso2' => 'LT'
],[
'country_id' => 38,
'name' => 'Adamawa',
'iso2' => 'AD'
],[
'country_id' => 38,
'name' => 'West',
'iso2' => 'OU'
],[
'country_id' => 38,
'name' => 'North',
'iso2' => 'NO'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
