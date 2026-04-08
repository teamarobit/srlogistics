<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateBJCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 795,
'name' => 'Beijing'
],[
'state_id' => 795,
'name' => 'Changping'
],[
'state_id' => 795,
'name' => 'Daxing'
],[
'state_id' => 795,
'name' => 'Fangshan'
],[
'state_id' => 795,
'name' => 'Liangxiang'
],[
'state_id' => 795,
'name' => 'Mentougou'
],[
'state_id' => 795,
'name' => 'Shunyi'
],[
'state_id' => 795,
'name' => 'Tongzhou'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
