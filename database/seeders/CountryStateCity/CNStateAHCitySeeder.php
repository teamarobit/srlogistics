<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateAHCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 789,
'name' => 'Anqing'
],[
'state_id' => 789,
'name' => 'Anqing Shi'
],[
'state_id' => 789,
'name' => 'Bengbu'
],[
'state_id' => 789,
'name' => 'Bozhou'
],[
'state_id' => 789,
'name' => 'Chaohu'
],[
'state_id' => 789,
'name' => 'Chizhou'
],[
'state_id' => 789,
'name' => 'Chizhou Shi'
],[
'state_id' => 789,
'name' => 'Chuzhou'
],[
'state_id' => 789,
'name' => 'Chuzhou Shi'
],[
'state_id' => 789,
'name' => 'Datong'
],[
'state_id' => 789,
'name' => 'Fuyang'
],[
'state_id' => 789,
'name' => 'Fuyang Shi'
],[
'state_id' => 789,
'name' => 'Gushu'
],[
'state_id' => 789,
'name' => 'Hefei'
],[
'state_id' => 789,
'name' => 'Hefei Shi'
],[
'state_id' => 789,
'name' => 'Huaibei'
],[
'state_id' => 789,
'name' => 'Huainan'
],[
'state_id' => 789,
'name' => 'Huainan Shi'
],[
'state_id' => 789,
'name' => 'Huaiyuan Chengguanzhen'
],[
'state_id' => 789,
'name' => 'Huangshan'
],[
'state_id' => 789,
'name' => 'Huangshan Shi'
],[
'state_id' => 789,
'name' => 'Huoqiu Chengguanzhen'
],[
'state_id' => 789,
'name' => 'Jieshou'
],[
'state_id' => 789,
'name' => 'Lucheng'
],[
'state_id' => 789,
'name' => 'Lu’an'
],[
'state_id' => 789,
'name' => 'Mengcheng Chengguanzhen'
],[
'state_id' => 789,
'name' => 'Mingguang'
],[
'state_id' => 789,
'name' => 'Suixi'
],[
'state_id' => 789,
'name' => 'Suzhou'
],[
'state_id' => 789,
'name' => 'Suzhou Shi'
],[
'state_id' => 789,
'name' => 'Tangzhai'
],[
'state_id' => 789,
'name' => 'Wucheng'
],[
'state_id' => 789,
'name' => 'Wuhu'
],[
'state_id' => 789,
'name' => 'Wusong'
],[
'state_id' => 789,
'name' => 'Wuyang'
],[
'state_id' => 789,
'name' => 'Xuanzhou'
],[
'state_id' => 789,
'name' => 'Yingshang Chengguanzhen'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
