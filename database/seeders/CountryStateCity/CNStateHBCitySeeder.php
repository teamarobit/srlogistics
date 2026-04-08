<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateHBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 812,
'name' => 'Anlu'
],[
'state_id' => 812,
'name' => 'Buhe'
],[
'state_id' => 812,
'name' => 'Caidian'
],[
'state_id' => 812,
'name' => 'Caohe'
],[
'state_id' => 812,
'name' => 'Chengzhong'
],[
'state_id' => 812,
'name' => 'Danjiangkou'
],[
'state_id' => 812,
'name' => 'Daye'
],[
'state_id' => 812,
'name' => 'Duobao'
],[
'state_id' => 812,
'name' => 'Enshi'
],[
'state_id' => 812,
'name' => 'Enshi Tujiazu Miaozu Zizhizhou'
],[
'state_id' => 812,
'name' => 'Ezhou'
],[
'state_id' => 812,
'name' => 'Ezhou Shi'
],[
'state_id' => 812,
'name' => 'Fengkou'
],[
'state_id' => 812,
'name' => 'Guangshui'
],[
'state_id' => 812,
'name' => 'Gucheng Chengguanzhen'
],[
'state_id' => 812,
'name' => 'Hanchuan'
],[
'state_id' => 812,
'name' => 'Huanggang'
],[
'state_id' => 812,
'name' => 'Huangmei'
],[
'state_id' => 812,
'name' => 'Huangpi'
],[
'state_id' => 812,
'name' => 'Huangshi'
],[
'state_id' => 812,
'name' => 'Huangzhou'
],[
'state_id' => 812,
'name' => 'Jingling'
],[
'state_id' => 812,
'name' => 'Jingmen'
],[
'state_id' => 812,
'name' => 'Jingmen Shi'
],[
'state_id' => 812,
'name' => 'Jingzhou'
],[
'state_id' => 812,
'name' => 'Laohekou'
],[
'state_id' => 812,
'name' => 'Lichuan'
],[
'state_id' => 812,
'name' => 'Macheng'
],[
'state_id' => 812,
'name' => 'Nanzhang Chengguanzhen'
],[
'state_id' => 812,
'name' => 'Puqi'
],[
'state_id' => 812,
'name' => 'Qianjiang'
],[
'state_id' => 812,
'name' => 'Qingquan'
],[
'state_id' => 812,
'name' => 'Shashi'
],[
'state_id' => 812,
'name' => 'Shennongjia'
],[
'state_id' => 812,
'name' => 'Shiyan'
],[
'state_id' => 812,
'name' => 'Suizhou'
],[
'state_id' => 812,
'name' => 'Wuhan'
],[
'state_id' => 812,
'name' => 'Wuxue'
],[
'state_id' => 812,
'name' => 'Xiangyang'
],[
'state_id' => 812,
'name' => 'Xianning'
],[
'state_id' => 812,
'name' => 'Xianning Prefecture'
],[
'state_id' => 812,
'name' => 'Xiantao'
],[
'state_id' => 812,
'name' => 'Xiaogan'
],[
'state_id' => 812,
'name' => 'Xihe'
],[
'state_id' => 812,
'name' => 'Xindi'
],[
'state_id' => 812,
'name' => 'Xinshi'
],[
'state_id' => 812,
'name' => 'Xinzhou'
],[
'state_id' => 812,
'name' => 'Xiulin'
],[
'state_id' => 812,
'name' => 'Yichang'
],[
'state_id' => 812,
'name' => 'Yicheng'
],[
'state_id' => 812,
'name' => 'Yunmeng Chengguanzhen'
],[
'state_id' => 812,
'name' => 'Zaoyang'
],[
'state_id' => 812,
'name' => 'Zhicheng'
],[
'state_id' => 812,
'name' => 'Zhijiang'
],[
'state_id' => 812,
'name' => 'Zhongxiang'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
