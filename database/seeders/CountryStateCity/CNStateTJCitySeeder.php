<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateTJCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 814,
'name' => 'Badaogu'
],[
'state_id' => 814,
'name' => 'Baijian'
],[
'state_id' => 814,
'name' => 'Bamencheng'
],[
'state_id' => 814,
'name' => 'Bangjun'
],[
'state_id' => 814,
'name' => 'Beicang'
],[
'state_id' => 814,
'name' => 'Beihuaidian'
],[
'state_id' => 814,
'name' => 'Beilizigu'
],[
'state_id' => 814,
'name' => 'Biaokou'
],[
'state_id' => 814,
'name' => 'Binhai New Area'
],[
'state_id' => 814,
'name' => 'Caijiapu'
],[
'state_id' => 814,
'name' => 'Caodian'
],[
'state_id' => 814,
'name' => 'Chabaihu'
],[
'state_id' => 814,
'name' => 'Changtun'
],[
'state_id' => 814,
'name' => 'Chengtougu'
],[
'state_id' => 814,
'name' => 'Chitu'
],[
'state_id' => 814,
'name' => 'Cuijiamatou'
],[
'state_id' => 814,
'name' => 'Dadunqiu'
],[
'state_id' => 814,
'name' => 'Dakoutun'
],[
'state_id' => 814,
'name' => 'Dashentang'
],[
'state_id' => 814,
'name' => 'Dawangtai'
],[
'state_id' => 814,
'name' => 'Daxinzhuang'
],[
'state_id' => 814,
'name' => 'Dazhongzhuang'
],[
'state_id' => 814,
'name' => 'Dongditou'
],[
'state_id' => 814,
'name' => 'Dongshigu'
],[
'state_id' => 814,
'name' => 'Erwangzhuang'
],[
'state_id' => 814,
'name' => 'Fanzhuang'
],[
'state_id' => 814,
'name' => 'Fengtai (Ninghe)'
],[
'state_id' => 814,
'name' => 'Fuzhuang'
],[
'state_id' => 814,
'name' => 'Gaojingzhuang'
],[
'state_id' => 814,
'name' => 'Hanjiashu'
],[
'state_id' => 814,
'name' => 'Hebeitun'
],[
'state_id' => 814,
'name' => 'Hexiwu'
],[
'state_id' => 814,
'name' => 'Huangcaotuo'
],[
'state_id' => 814,
'name' => 'Huantuo'
],[
'state_id' => 814,
'name' => 'Huogezhuang'
],[
'state_id' => 814,
'name' => 'Jiangwakou'
],[
'state_id' => 814,
'name' => 'Zhangjiawo'
],[
'state_id' => 814,
'name' => 'Lianzhuang'
],[
'state_id' => 814,
'name' => 'Lintingkou'
],[
'state_id' => 814,
'name' => 'Liujiading'
],[
'state_id' => 814,
'name' => 'Liukuaizhuang'
],[
'state_id' => 814,
'name' => 'Liuzikou'
],[
'state_id' => 814,
'name' => 'Luotuofangzi'
],[
'state_id' => 814,
'name' => 'Meichang'
],[
'state_id' => 814,
'name' => 'Mengquan'
],[
'state_id' => 814,
'name' => 'Panzhuang'
],[
'state_id' => 814,
'name' => 'Qingguang'
],[
'state_id' => 814,
'name' => 'Sangzi'
],[
'state_id' => 814,
'name' => 'Shangcang'
],[
'state_id' => 814,
'name' => 'Shimianzhuang'
],[
'state_id' => 814,
'name' => 'Shuangjiang'
],[
'state_id' => 814,
'name' => 'Sigaozhuang'
],[
'state_id' => 814,
'name' => 'Tianjin'
],[
'state_id' => 814,
'name' => 'Touying'
],[
'state_id' => 814,
'name' => 'Wangqinzhuang'
],[
'state_id' => 814,
'name' => 'Weiwangzhuang'
],[
'state_id' => 814,
'name' => 'Xiawuqi'
],[
'state_id' => 814,
'name' => 'Xiditou'
],[
'state_id' => 814,
'name' => 'Xinkaikou'
],[
'state_id' => 814,
'name' => 'Xitazhuang'
],[
'state_id' => 814,
'name' => 'Yangjinzhuang'
],[
'state_id' => 814,
'name' => 'Yangliuqing'
],[
'state_id' => 814,
'name' => 'Yinliu'
],[
'state_id' => 814,
'name' => 'Yixingfu'
],[
'state_id' => 814,
'name' => 'Youguzhuang'
],[
'state_id' => 814,
'name' => 'Yuelongzhuang'
],[
'state_id' => 814,
'name' => 'Yuguzhuang'
],[
'state_id' => 814,
'name' => 'Zaojiacheng'
],[
'state_id' => 814,
'name' => 'Zhaoguli'
],[
'state_id' => 814,
'name' => 'Zhaoguli'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
