<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateQHCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 808,
'name' => 'Delingha'
],[
'state_id' => 808,
'name' => 'Golmud'
],[
'state_id' => 808,
'name' => 'Golog Tibetan Autonomous Prefecture'
],[
'state_id' => 808,
'name' => 'Haibei Tibetan Autonomous Prefecture'
],[
'state_id' => 808,
'name' => 'Huangnan Zangzu Zizhizhou'
],[
'state_id' => 808,
'name' => 'Xining'
],[
'state_id' => 808,
'name' => 'Xireg'
],[
'state_id' => 808,
'name' => 'Yushu Zangzu Zizhizhou'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
