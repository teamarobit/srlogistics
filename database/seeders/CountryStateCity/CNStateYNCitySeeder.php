<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateYNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 798,
'name' => 'Chuxiong Yizu Zizhizhou'
],[
'state_id' => 798,
'name' => 'Dali'
],[
'state_id' => 798,
'name' => 'Dali Baizu Zizhizhou'
],[
'state_id' => 798,
'name' => 'Dehong Daizu Jingpozu Zizhizhou'
],[
'state_id' => 798,
'name' => 'Dêqên Tibetan Autonomous Prefecture'
],[
'state_id' => 798,
'name' => 'Gejiu'
],[
'state_id' => 798,
'name' => 'Haikou'
],[
'state_id' => 798,
'name' => 'Honghe Hanizu Yizu Zizhizhou'
],[
'state_id' => 798,
'name' => 'Jinghong'
],[
'state_id' => 798,
'name' => 'Kaihua'
],[
'state_id' => 798,
'name' => 'Kaiyuan'
],[
'state_id' => 798,
'name' => 'Kunming'
],[
'state_id' => 798,
'name' => 'Lianran'
],[
'state_id' => 798,
'name' => 'Lijiang'
],[
'state_id' => 798,
'name' => 'Lincang Shi'
],[
'state_id' => 798,
'name' => 'Longquan'
],[
'state_id' => 798,
'name' => 'Mabai'
],[
'state_id' => 798,
'name' => 'Majie'
],[
'state_id' => 798,
'name' => 'Miyang'
],[
'state_id' => 798,
'name' => 'Nujiang Lisuzu Zizhizhou'
],[
'state_id' => 798,
'name' => 'Qujing'
],[
'state_id' => 798,
'name' => 'Shangri-La'
],[
'state_id' => 798,
'name' => 'Shilin'
],[
'state_id' => 798,
'name' => 'Wenlan'
],[
'state_id' => 798,
'name' => 'Wenshan City'
],[
'state_id' => 798,
'name' => 'Wenshan Zhuangzu Miaozu Zizhizhou'
],[
'state_id' => 798,
'name' => 'Yuxi'
],[
'state_id' => 798,
'name' => 'Zhaotong'
],[
'state_id' => 798,
'name' => 'Zhongshu'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
