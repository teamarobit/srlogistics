<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateSNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 810,
'name' => 'Ankang'
],[
'state_id' => 810,
'name' => 'Baoji Shi'
],[
'state_id' => 810,
'name' => 'Guozhen'
],[
'state_id' => 810,
'name' => 'Hancheng'
],[
'state_id' => 810,
'name' => 'Hanzhong'
],[
'state_id' => 810,
'name' => 'Huayin'
],[
'state_id' => 810,
'name' => 'Lintong'
],[
'state_id' => 810,
'name' => 'Tongchuanshi'
],[
'state_id' => 810,
'name' => 'Weinan'
],[
'state_id' => 810,
'name' => 'Xianyang'
],[
'state_id' => 810,
'name' => 'Xi’an'
],[
'state_id' => 810,
'name' => 'Yanliang'
],[
'state_id' => 810,
'name' => 'Yulinshi'
],[
'state_id' => 810,
'name' => 'Yuxia'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
