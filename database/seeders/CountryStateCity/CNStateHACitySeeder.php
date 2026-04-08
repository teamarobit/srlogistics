<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateHACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 797,
'name' => 'Anyang'
],[
'state_id' => 797,
'name' => 'Anyang Shi'
],[
'state_id' => 797,
'name' => 'Binhe'
],[
'state_id' => 797,
'name' => 'Chengguan'
],[
'state_id' => 797,
'name' => 'Chengjiao'
],[
'state_id' => 797,
'name' => 'Daokou'
],[
'state_id' => 797,
'name' => 'Dingcheng'
],[
'state_id' => 797,
'name' => 'Hancheng'
],[
'state_id' => 797,
'name' => 'Hebi'
],[
'state_id' => 797,
'name' => 'Huaidian'
],[
'state_id' => 797,
'name' => 'Huazhou'
],[
'state_id' => 797,
'name' => 'Huichang'
],[
'state_id' => 797,
'name' => 'Jianshe'
],[
'state_id' => 797,
'name' => 'Jiaozuo'
],[
'state_id' => 797,
'name' => 'Jishui'
],[
'state_id' => 797,
'name' => 'Jiyuan'
],[
'state_id' => 797,
'name' => 'Kaifeng'
],[
'state_id' => 797,
'name' => 'Kaiyuan'
],[
'state_id' => 797,
'name' => 'Lingbao Chengguanzhen'
],[
'state_id' => 797,
'name' => 'Luohe'
],[
'state_id' => 797,
'name' => 'Luohe Shi'
],[
'state_id' => 797,
'name' => 'Luoyang'
],[
'state_id' => 797,
'name' => 'Minggang'
],[
'state_id' => 797,
'name' => 'Nanyang'
],[
'state_id' => 797,
'name' => 'Pingdingshan'
],[
'state_id' => 797,
'name' => 'Puyang Chengguanzhen'
],[
'state_id' => 797,
'name' => 'Puyang Shi'
],[
'state_id' => 797,
'name' => 'Qingping'
],[
'state_id' => 797,
'name' => 'Runing'
],[
'state_id' => 797,
'name' => 'Ruzhou'
],[
'state_id' => 797,
'name' => 'Shangqiu'
],[
'state_id' => 797,
'name' => 'Songyang'
],[
'state_id' => 797,
'name' => 'Suohe'
],[
'state_id' => 797,
'name' => 'Tanbei'
],[
'state_id' => 797,
'name' => 'Wacheng'
],[
'state_id' => 797,
'name' => 'Xiangcheng Chengguanzhen'
],[
'state_id' => 797,
'name' => 'Xincheng'
],[
'state_id' => 797,
'name' => 'Xinhualu'
],[
'state_id' => 797,
'name' => 'Xinxiang'
],[
'state_id' => 797,
'name' => 'Xinxiang Shi'
],[
'state_id' => 797,
'name' => 'Xinyang'
],[
'state_id' => 797,
'name' => 'Xixiang'
],[
'state_id' => 797,
'name' => 'Xuchang'
],[
'state_id' => 797,
'name' => 'Xuchang Shi'
],[
'state_id' => 797,
'name' => 'Yakou'
],[
'state_id' => 797,
'name' => 'Yanshi Chengguanzhen'
],[
'state_id' => 797,
'name' => 'Yigou'
],[
'state_id' => 797,
'name' => 'Yima'
],[
'state_id' => 797,
'name' => 'Yingchuan'
],[
'state_id' => 797,
'name' => 'Yunyang'
],[
'state_id' => 797,
'name' => 'Zhengzhou'
],[
'state_id' => 797,
'name' => 'Zhoukou'
],[
'state_id' => 797,
'name' => 'Zhumadian'
],[
'state_id' => 797,
'name' => 'Zhumadian Shi'
],[
'state_id' => 797,
'name' => 'Zijinglu'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
