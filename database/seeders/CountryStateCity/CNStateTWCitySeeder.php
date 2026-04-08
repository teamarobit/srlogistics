<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateTWCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 793,
'name' => 'Baoying'
],[
'state_id' => 793,
'name' => 'Changshu City'
],[
'state_id' => 793,
'name' => 'Changzhou'
],[
'state_id' => 793,
'name' => 'Chengxiang'
],[
'state_id' => 793,
'name' => 'Dazhong'
],[
'state_id' => 793,
'name' => 'Dongkan'
],[
'state_id' => 793,
'name' => 'Dongtai'
],[
'state_id' => 793,
'name' => 'Fengxian'
],[
'state_id' => 793,
'name' => 'Gaogou'
],[
'state_id' => 793,
'name' => 'Gaoyou'
],[
'state_id' => 793,
'name' => 'Guiren'
],[
'state_id' => 793,
'name' => 'Haizhou'
],[
'state_id' => 793,
'name' => 'Hede'
],[
'state_id' => 793,
'name' => 'Huai\'an'
],[
'state_id' => 793,
'name' => 'Huai’an Shi'
],[
'state_id' => 793,
'name' => 'Huilong'
],[
'state_id' => 793,
'name' => 'Hutang'
],[
'state_id' => 793,
'name' => 'Jiangyan'
],[
'state_id' => 793,
'name' => 'Jiangyin'
],[
'state_id' => 793,
'name' => 'Jingjiang'
],[
'state_id' => 793,
'name' => 'Jinsha'
],[
'state_id' => 793,
'name' => 'Juegang'
],[
'state_id' => 793,
'name' => 'Kunshan'
],[
'state_id' => 793,
'name' => 'Lianyungang Shi'
],[
'state_id' => 793,
'name' => 'Licheng'
],[
'state_id' => 793,
'name' => 'Mudu'
],[
'state_id' => 793,
'name' => 'Nanjing'
],[
'state_id' => 793,
'name' => 'Nantong'
],[
'state_id' => 793,
'name' => 'Pizhou'
],[
'state_id' => 793,
'name' => 'Qinnan'
],[
'state_id' => 793,
'name' => 'Rucheng'
],[
'state_id' => 793,
'name' => 'Sanmao'
],[
'state_id' => 793,
'name' => 'Songling'
],[
'state_id' => 793,
'name' => 'Suicheng'
],[
'state_id' => 793,
'name' => 'Suzhou'
],[
'state_id' => 793,
'name' => 'Taixing'
],[
'state_id' => 793,
'name' => 'Taizhou'
],[
'state_id' => 793,
'name' => 'Tongshan'
],[
'state_id' => 793,
'name' => 'Wuxi'
],[
'state_id' => 793,
'name' => 'Xiannü'
],[
'state_id' => 793,
'name' => 'Xiaolingwei'
],[
'state_id' => 793,
'name' => 'Xinghua'
],[
'state_id' => 793,
'name' => 'Xinpu'
],[
'state_id' => 793,
'name' => 'Yancheng'
],[
'state_id' => 793,
'name' => 'Yangzhou'
],[
'state_id' => 793,
'name' => 'Yicheng'
],[
'state_id' => 793,
'name' => 'Yushan'
],[
'state_id' => 793,
'name' => 'Zhangjiagang'
],[
'state_id' => 793,
'name' => 'Zhenjiang'
],[
'state_id' => 793,
'name' => 'Zhenzhou'
],[
'state_id' => 793,
'name' => 'Zhongxing'
],[
'state_id' => 793,
'name' => 'Zhouzhuang'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
