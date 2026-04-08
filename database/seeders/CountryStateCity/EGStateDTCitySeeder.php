<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateDTCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1154,
'name' => 'Az Zarqā'
],[
'state_id' => 1154,
'name' => 'Damietta'
],[
'state_id' => 1154,
'name' => 'Fāraskūr'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
