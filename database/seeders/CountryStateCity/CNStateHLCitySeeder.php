<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateHLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 803,
'name' => 'Acheng'
],[
'state_id' => 803,
'name' => 'Anda'
],[
'state_id' => 803,
'name' => 'Baiquan'
],[
'state_id' => 803,
'name' => 'Bamiantong'
],[
'state_id' => 803,
'name' => 'Baoqing'
],[
'state_id' => 803,
'name' => 'Baoshan'
],[
'state_id' => 803,
'name' => 'Bayan'
],[
'state_id' => 803,
'name' => 'Bei’an'
],[
'state_id' => 803,
'name' => 'Binzhou'
],[
'state_id' => 803,
'name' => 'Boli'
],[
'state_id' => 803,
'name' => 'Chaihe'
],[
'state_id' => 803,
'name' => 'Chengzihe'
],[
'state_id' => 803,
'name' => 'Daqing'
],[
'state_id' => 803,
'name' => 'Dongning'
],[
'state_id' => 803,
'name' => 'Dongxing'
],[
'state_id' => 803,
'name' => 'Fendou'
],[
'state_id' => 803,
'name' => 'Fengxiang'
],[
'state_id' => 803,
'name' => 'Fujin'
],[
'state_id' => 803,
'name' => 'Fuli'
],[
'state_id' => 803,
'name' => 'Fuyu'
],[
'state_id' => 803,
'name' => 'Fuyuan'
],[
'state_id' => 803,
'name' => 'Gannan'
],[
'state_id' => 803,
'name' => 'Hailin'
],[
'state_id' => 803,
'name' => 'Hailun'
],[
'state_id' => 803,
'name' => 'Harbin'
],[
'state_id' => 803,
'name' => 'Hegang'
],[
'state_id' => 803,
'name' => 'Heihe'
],[
'state_id' => 803,
'name' => 'Honggang'
],[
'state_id' => 803,
'name' => 'Huanan'
],[
'state_id' => 803,
'name' => 'Hulan'
],[
'state_id' => 803,
'name' => 'Hulan Ergi'
],[
'state_id' => 803,
'name' => 'Jiamusi'
],[
'state_id' => 803,
'name' => 'Jidong'
],[
'state_id' => 803,
'name' => 'Jixi'
],[
'state_id' => 803,
'name' => 'Langxiang'
],[
'state_id' => 803,
'name' => 'Lanxi'
],[
'state_id' => 803,
'name' => 'Lianhe'
],[
'state_id' => 803,
'name' => 'Lingdong'
],[
'state_id' => 803,
'name' => 'Linkou'
],[
'state_id' => 803,
'name' => 'Longfeng'
],[
'state_id' => 803,
'name' => 'Longjiang'
],[
'state_id' => 803,
'name' => 'Mingshui'
],[
'state_id' => 803,
'name' => 'Mishan'
],[
'state_id' => 803,
'name' => 'Mudanjiang'
],[
'state_id' => 803,
'name' => 'Nehe'
],[
'state_id' => 803,
'name' => 'Nenjiang'
],[
'state_id' => 803,
'name' => 'Nianzishan'
],[
'state_id' => 803,
'name' => 'Ning’an'
],[
'state_id' => 803,
'name' => 'Qinggang'
],[
'state_id' => 803,
'name' => 'Qiqihar'
],[
'state_id' => 803,
'name' => 'Shangzhi'
],[
'state_id' => 803,
'name' => 'Shanhecun'
],[
'state_id' => 803,
'name' => 'Shuangcheng'
],[
'state_id' => 803,
'name' => 'Shuangyashan'
],[
'state_id' => 803,
'name' => 'Suifenhe'
],[
'state_id' => 803,
'name' => 'Suihua'
],[
'state_id' => 803,
'name' => 'Suileng'
],[
'state_id' => 803,
'name' => 'Tahe'
],[
'state_id' => 803,
'name' => 'Taihecun'
],[
'state_id' => 803,
'name' => 'Taikang'
],[
'state_id' => 803,
'name' => 'Tailai'
],[
'state_id' => 803,
'name' => 'Tieli'
],[
'state_id' => 803,
'name' => 'Wangkui'
],[
'state_id' => 803,
'name' => 'Wuchang'
],[
'state_id' => 803,
'name' => 'Xinqing'
],[
'state_id' => 803,
'name' => 'Yichun'
],[
'state_id' => 803,
'name' => 'Yilan'
],[
'state_id' => 803,
'name' => 'Youhao'
],[
'state_id' => 803,
'name' => 'Zhaodong'
],[
'state_id' => 803,
'name' => 'Zhaoyuan'
],[
'state_id' => 803,
'name' => 'Zhaozhou'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
