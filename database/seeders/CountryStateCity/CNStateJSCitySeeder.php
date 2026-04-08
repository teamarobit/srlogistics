<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateJSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 788,
'name' => 'NanJing'
],[
'state_id' => 788,
'name' => 'WuXi'
],[
'state_id' => 788,
'name' => 'XuZhou'
],[
'state_id' => 788,
'name' => 'ChangZhou'
],[
'state_id' => 788,
'name' => 'SuZhou'
],[
'state_id' => 788,
'name' => 'NanTong'
],[
'state_id' => 788,
'name' => 'LianYunGang'
],[
'state_id' => 788,
'name' => 'HuaiAn'
],[
'state_id' => 788,
'name' => 'YanCheng'
],[
'state_id' => 788,
'name' => 'YangZhou'
],[
'state_id' => 788,
'name' => 'ZhenJiang'
],[
'state_id' => 788,
'name' => 'TaiZhou'
],[
'state_id' => 788,
'name' => 'SuQian'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
