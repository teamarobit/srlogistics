<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GHStateNECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1452,
'name' => 'Bunkpurugu-Nyakpanduri'
],[
'state_id' => 1452,
'name' => 'Chereponi'
],[
'state_id' => 1452,
'name' => 'East Mamprusi'
],[
'state_id' => 1452,
'name' => 'Mamprugu-Moagduri'
],[
'state_id' => 1452,
'name' => 'West Mamprusi'
],[
'state_id' => 1452,
'name' => 'Yunyoo-Nasuan'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
