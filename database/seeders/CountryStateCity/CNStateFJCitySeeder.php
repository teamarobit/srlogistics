<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateFJCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 786,
'name' => 'Badu'
],[
'state_id' => 786,
'name' => 'Baiqi'
],[
'state_id' => 786,
'name' => 'Baiyun'
],[
'state_id' => 786,
'name' => 'Beishancun'
],[
'state_id' => 786,
'name' => 'Changqiao'
],[
'state_id' => 786,
'name' => 'Chengmen'
],[
'state_id' => 786,
'name' => 'Chixi'
],[
'state_id' => 786,
'name' => 'Chongru'
],[
'state_id' => 786,
'name' => 'Dadeng'
],[
'state_id' => 786,
'name' => 'Daixi'
],[
'state_id' => 786,
'name' => 'Danyang'
],[
'state_id' => 786,
'name' => 'Daqiao'
],[
'state_id' => 786,
'name' => 'Dazuo'
],[
'state_id' => 786,
'name' => 'Dinghaicun'
],[
'state_id' => 786,
'name' => 'Dingtoucun'
],[
'state_id' => 786,
'name' => 'Dongchongcun'
],[
'state_id' => 786,
'name' => 'Dongdai'
],[
'state_id' => 786,
'name' => 'Donghu'
],[
'state_id' => 786,
'name' => 'Dongling'
],[
'state_id' => 786,
'name' => 'Dongyuan'
],[
'state_id' => 786,
'name' => 'Feiluan'
],[
'state_id' => 786,
'name' => 'Fengpu'
],[
'state_id' => 786,
'name' => 'Fengzhou'
],[
'state_id' => 786,
'name' => 'Fuding'
],[
'state_id' => 786,
'name' => 'Fuqing'
],[
'state_id' => 786,
'name' => 'Fuzhou'
],[
'state_id' => 786,
'name' => 'Fu’an'
],[
'state_id' => 786,
'name' => 'Gantang'
],[
'state_id' => 786,
'name' => 'Guantou'
],[
'state_id' => 786,
'name' => 'Gufeng'
],[
'state_id' => 786,
'name' => 'Hetang'
],[
'state_id' => 786,
'name' => 'Hongtang'
],[
'state_id' => 786,
'name' => 'Hongyang'
],[
'state_id' => 786,
'name' => 'Houyu'
],[
'state_id' => 786,
'name' => 'Huai’an'
],[
'state_id' => 786,
'name' => 'Huangtian'
],[
'state_id' => 786,
'name' => 'Huotong'
],[
'state_id' => 786,
'name' => 'Jiangkou'
],[
'state_id' => 786,
'name' => 'Jianjiang'
],[
'state_id' => 786,
'name' => 'Jian’ou'
],[
'state_id' => 786,
'name' => 'Jingfeng'
],[
'state_id' => 786,
'name' => 'Jinjiang'
],[
'state_id' => 786,
'name' => 'Jinjing'
],[
'state_id' => 786,
'name' => 'Jitoucun'
],[
'state_id' => 786,
'name' => 'Kengyuan'
],[
'state_id' => 786,
'name' => 'Kerencun'
],[
'state_id' => 786,
'name' => 'Kuai’an'
],[
'state_id' => 786,
'name' => 'Lianhecun'
],[
'state_id' => 786,
'name' => 'Liuwudiancun'
],[
'state_id' => 786,
'name' => 'Longmen'
],[
'state_id' => 786,
'name' => 'Longyan'
],[
'state_id' => 786,
'name' => 'Luoqiao'
],[
'state_id' => 786,
'name' => 'Luoyang'
],[
'state_id' => 786,
'name' => 'Luxia'
],[
'state_id' => 786,
'name' => 'Maping'
],[
'state_id' => 786,
'name' => 'Meipu'
],[
'state_id' => 786,
'name' => 'Min’an'
],[
'state_id' => 786,
'name' => 'Nanping'
],[
'state_id' => 786,
'name' => 'Neikeng'
],[
'state_id' => 786,
'name' => 'Ningde'
],[
'state_id' => 786,
'name' => 'Pandu'
],[
'state_id' => 786,
'name' => 'Pucheng'
],[
'state_id' => 786,
'name' => 'Putian'
],[
'state_id' => 786,
'name' => 'Qibu'
],[
'state_id' => 786,
'name' => 'Qidu'
],[
'state_id' => 786,
'name' => 'Quanzhou'
],[
'state_id' => 786,
'name' => 'Rong’an'
],[
'state_id' => 786,
'name' => 'Sanming'
],[
'state_id' => 786,
'name' => 'Shajiang'
],[
'state_id' => 786,
'name' => 'Shangjie'
],[
'state_id' => 786,
'name' => 'Shanxia'
],[
'state_id' => 786,
'name' => 'Shanyang'
],[
'state_id' => 786,
'name' => 'Shaowu'
],[
'state_id' => 786,
'name' => 'Shijing'
],[
'state_id' => 786,
'name' => 'Shima'
],[
'state_id' => 786,
'name' => 'Shoushan'
],[
'state_id' => 786,
'name' => 'Shuangxi'
],[
'state_id' => 786,
'name' => 'Shuangzhu'
],[
'state_id' => 786,
'name' => 'Shuikou'
],[
'state_id' => 786,
'name' => 'Tangkou'
],[
'state_id' => 786,
'name' => 'Tantou'
],[
'state_id' => 786,
'name' => 'Tatou'
],[
'state_id' => 786,
'name' => 'Tingjiang'
],[
'state_id' => 786,
'name' => 'Tuzhai'
],[
'state_id' => 786,
'name' => 'Wubao'
],[
'state_id' => 786,
'name' => 'Wuyishan'
],[
'state_id' => 786,
'name' => 'Wuyucun'
],[
'state_id' => 786,
'name' => 'Xiabaishi'
],[
'state_id' => 786,
'name' => 'Xiahu'
],[
'state_id' => 786,
'name' => 'Xiamen'
],[
'state_id' => 786,
'name' => 'Xiancun'
],[
'state_id' => 786,
'name' => 'Xiangyun'
],[
'state_id' => 786,
'name' => 'Xibing'
],[
'state_id' => 786,
'name' => 'Xiling'
],[
'state_id' => 786,
'name' => 'Ximei'
],[
'state_id' => 786,
'name' => 'Xinan'
],[
'state_id' => 786,
'name' => 'Xindian'
],[
'state_id' => 786,
'name' => 'Yakou'
],[
'state_id' => 786,
'name' => 'Yanghou'
],[
'state_id' => 786,
'name' => 'Yangzhong'
],[
'state_id' => 786,
'name' => 'Yantian'
],[
'state_id' => 786,
'name' => 'Yingdu'
],[
'state_id' => 786,
'name' => 'Yinglin'
],[
'state_id' => 786,
'name' => 'Yongning'
],[
'state_id' => 786,
'name' => 'Yushan'
],[
'state_id' => 786,
'name' => 'Zhangwan'
],[
'state_id' => 786,
'name' => 'Zhangzhou'
],[
'state_id' => 786,
'name' => 'Zhenhaicun'
],[
'state_id' => 786,
'name' => 'Zhongfang'
],[
'state_id' => 786,
'name' => 'Zhuoyang'
],[
'state_id' => 786,
'name' => 'Zhuqi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
