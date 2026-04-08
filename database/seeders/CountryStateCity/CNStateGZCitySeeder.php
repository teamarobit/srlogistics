<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateGZCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 799,
'name' => 'Anshun'
],[
'state_id' => 799,
'name' => 'Aoshi'
],[
'state_id' => 799,
'name' => 'Bahuang'
],[
'state_id' => 799,
'name' => 'Baishi'
],[
'state_id' => 799,
'name' => 'Bangdong'
],[
'state_id' => 799,
'name' => 'Benchu'
],[
'state_id' => 799,
'name' => 'Bijie'
],[
'state_id' => 799,
'name' => 'Chadian'
],[
'state_id' => 799,
'name' => 'Changsha'
],[
'state_id' => 799,
'name' => 'Chumi'
],[
'state_id' => 799,
'name' => 'Dabachang'
],[
'state_id' => 799,
'name' => 'Darong'
],[
'state_id' => 799,
'name' => 'Dundong'
],[
'state_id' => 799,
'name' => 'Duyun'
],[
'state_id' => 799,
'name' => 'Gaoniang'
],[
'state_id' => 799,
'name' => 'Gaowu'
],[
'state_id' => 799,
'name' => 'Gaozeng'
],[
'state_id' => 799,
'name' => 'Guandu'
],[
'state_id' => 799,
'name' => 'Guiyang'
],[
'state_id' => 799,
'name' => 'Huaqiu'
],[
'state_id' => 799,
'name' => 'Lantian'
],[
'state_id' => 799,
'name' => 'Liangcunchang'
],[
'state_id' => 799,
'name' => 'Liupanshui'
],[
'state_id' => 799,
'name' => 'Longlisuo'
],[
'state_id' => 799,
'name' => 'Loushanguan'
],[
'state_id' => 799,
'name' => 'Maoping'
],[
'state_id' => 799,
'name' => 'Ouyang'
],[
'state_id' => 799,
'name' => 'Pingjiang'
],[
'state_id' => 799,
'name' => 'Qiandongnan Miao and Dong Autonomous Prefecture'
],[
'state_id' => 799,
'name' => 'Qianxinan Bouyeizu Miaozu Zizhizhou'
],[
'state_id' => 799,
'name' => 'Qimeng'
],[
'state_id' => 799,
'name' => 'Qinglang'
],[
'state_id' => 799,
'name' => 'Runsong'
],[
'state_id' => 799,
'name' => 'Sanchahe'
],[
'state_id' => 799,
'name' => 'Sangmu'
],[
'state_id' => 799,
'name' => 'Shiqian'
],[
'state_id' => 799,
'name' => 'Songkan'
],[
'state_id' => 799,
'name' => 'Tingdong'
],[
'state_id' => 799,
'name' => 'Tonggu'
],[
'state_id' => 799,
'name' => 'Tongren'
],[
'state_id' => 799,
'name' => 'Tongren Diqu'
],[
'state_id' => 799,
'name' => 'Weining'
],[
'state_id' => 799,
'name' => 'Wenshui'
],[
'state_id' => 799,
'name' => 'Xiajiang'
],[
'state_id' => 799,
'name' => 'Xiaoweizhai'
],[
'state_id' => 799,
'name' => 'Xinzhan'
],[
'state_id' => 799,
'name' => 'Xishan'
],[
'state_id' => 799,
'name' => 'Xujiaba'
],[
'state_id' => 799,
'name' => 'Yangtou'
],[
'state_id' => 799,
'name' => 'Youyupu'
],[
'state_id' => 799,
'name' => 'Zhongchao'
],[
'state_id' => 799,
'name' => 'Zhujiachang'
],[
'state_id' => 799,
'name' => 'Zunyi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
