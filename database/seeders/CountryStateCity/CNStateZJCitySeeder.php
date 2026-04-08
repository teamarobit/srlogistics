<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateZJCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 785,
'name' => 'Deqing'
],[
'state_id' => 785,
'name' => 'Dongyang'
],[
'state_id' => 785,
'name' => 'Fenghua'
],[
'state_id' => 785,
'name' => 'Fuyang'
],[
'state_id' => 785,
'name' => 'Guli'
],[
'state_id' => 785,
'name' => 'Haining'
],[
'state_id' => 785,
'name' => 'Hangzhou'
],[
'state_id' => 785,
'name' => 'Huangyan'
],[
'state_id' => 785,
'name' => 'Huzhou'
],[
'state_id' => 785,
'name' => 'Jiaojiang'
],[
'state_id' => 785,
'name' => 'Jiashan'
],[
'state_id' => 785,
'name' => 'Jiaxing'
],[
'state_id' => 785,
'name' => 'Jiaxing Shi'
],[
'state_id' => 785,
'name' => 'Jinhua'
],[
'state_id' => 785,
'name' => 'Jinxiang'
],[
'state_id' => 785,
'name' => 'Kunyang'
],[
'state_id' => 785,
'name' => 'Lanxi'
],[
'state_id' => 785,
'name' => 'Lianghu'
],[
'state_id' => 785,
'name' => 'Linhai'
],[
'state_id' => 785,
'name' => 'Linping'
],[
'state_id' => 785,
'name' => 'Lishui'
],[
'state_id' => 785,
'name' => 'Luqiao'
],[
'state_id' => 785,
'name' => 'Ningbo'
],[
'state_id' => 785,
'name' => 'Ninghai'
],[
'state_id' => 785,
'name' => 'Puyang'
],[
'state_id' => 785,
'name' => 'Quzhou'
],[
'state_id' => 785,
'name' => 'Shangyu'
],[
'state_id' => 785,
'name' => 'Shaoxing'
],[
'state_id' => 785,
'name' => 'Shenjiamen'
],[
'state_id' => 785,
'name' => 'Taizhou'
],[
'state_id' => 785,
'name' => 'Wenling'
],[
'state_id' => 785,
'name' => 'Wenzhou'
],[
'state_id' => 785,
'name' => 'Wuzhen'
],[
'state_id' => 785,
'name' => 'Xianju'
],[
'state_id' => 785,
'name' => 'Xiaoshan'
],[
'state_id' => 785,
'name' => 'Yiwu'
],[
'state_id' => 785,
'name' => 'Yuyao'
],[
'state_id' => 785,
'name' => 'Zhaobaoshan'
],[
'state_id' => 785,
'name' => 'Zhicheng'
],[
'state_id' => 785,
'name' => 'Zhoushan'
],[
'state_id' => 785,
'name' => 'Zhuji'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
