<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateNXCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 800,
'name' => 'Dawukou'
],[
'state_id' => 800,
'name' => 'Dongta'
],[
'state_id' => 800,
'name' => 'Shitanjing'
],[
'state_id' => 800,
'name' => 'Shizuishan'
],[
'state_id' => 800,
'name' => 'Wuzhong'
],[
'state_id' => 800,
'name' => 'Yinchuan'
],[
'state_id' => 800,
'name' => 'Zhongwei'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
