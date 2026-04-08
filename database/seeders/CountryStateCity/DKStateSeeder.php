<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class DKStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 59,
'name' => 'Region Zealand',
'iso2' => '85'
],[
'country_id' => 59,
'name' => 'Region of Southern Denmark',
'iso2' => '83'
],[
'country_id' => 59,
'name' => 'Capital Region of Denmark',
'iso2' => '84'
],[
'country_id' => 59,
'name' => 'Central Denmark Region',
'iso2' => '82'
],[
'country_id' => 59,
'name' => 'North Denmark Region',
'iso2' => '81'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
