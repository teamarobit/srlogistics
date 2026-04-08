<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateSCCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 815,
'name' => 'Aba Zangzu Qiangzu Zizhizhou'
],[
'state_id' => 815,
'name' => 'Barkam'
],[
'state_id' => 815,
'name' => 'Bazhong Shi'
],[
'state_id' => 815,
'name' => 'Changchi'
],[
'state_id' => 815,
'name' => 'Chengdu'
],[
'state_id' => 815,
'name' => 'Chonglong'
],[
'state_id' => 815,
'name' => 'Dadukou'
],[
'state_id' => 815,
'name' => 'Dazhou'
],[
'state_id' => 815,
'name' => 'Deyang'
],[
'state_id' => 815,
'name' => 'Dongxi'
],[
'state_id' => 815,
'name' => 'Fangting'
],[
'state_id' => 815,
'name' => 'Fubao'
],[
'state_id' => 815,
'name' => 'Gaoping'
],[
'state_id' => 815,
'name' => 'Garzê Zangzu Zizhizhou'
],[
'state_id' => 815,
'name' => 'Guangyuan'
],[
'state_id' => 815,
'name' => 'Guang’an'
],[
'state_id' => 815,
'name' => 'Jiancheng'
],[
'state_id' => 815,
'name' => 'Jiangyou'
],[
'state_id' => 815,
'name' => 'Jiannan'
],[
'state_id' => 815,
'name' => 'Kangding'
],[
'state_id' => 815,
'name' => 'Langzhong'
],[
'state_id' => 815,
'name' => 'Leshan'
],[
'state_id' => 815,
'name' => 'Liangshan Yizu Zizhizhou'
],[
'state_id' => 815,
'name' => 'Linqiong'
],[
'state_id' => 815,
'name' => 'Luocheng'
],[
'state_id' => 815,
'name' => 'Luzhou'
],[
'state_id' => 815,
'name' => 'Meishan Shi'
],[
'state_id' => 815,
'name' => 'Mianyang'
],[
'state_id' => 815,
'name' => 'Nanchong'
],[
'state_id' => 815,
'name' => 'Nanlong'
],[
'state_id' => 815,
'name' => 'Neijiang'
],[
'state_id' => 815,
'name' => 'Panzhihua'
],[
'state_id' => 815,
'name' => 'Puji'
],[
'state_id' => 815,
'name' => 'Shuanghejiedao'
],[
'state_id' => 815,
'name' => 'Suining'
],[
'state_id' => 815,
'name' => 'Taihe'
],[
'state_id' => 815,
'name' => 'Taiping'
],[
'state_id' => 815,
'name' => 'Tianpeng'
],[
'state_id' => 815,
'name' => 'Tongchuan'
],[
'state_id' => 815,
'name' => 'Xialiang'
],[
'state_id' => 815,
'name' => 'Xiantan'
],[
'state_id' => 815,
'name' => 'Xichang'
],[
'state_id' => 815,
'name' => 'Xunchang'
],[
'state_id' => 815,
'name' => 'Yanjiang'
],[
'state_id' => 815,
'name' => 'Yibin'
],[
'state_id' => 815,
'name' => 'Yucheng'
],[
'state_id' => 815,
'name' => 'Zengjia'
],[
'state_id' => 815,
'name' => 'Zhongba'
],[
'state_id' => 815,
'name' => 'Zigong'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
