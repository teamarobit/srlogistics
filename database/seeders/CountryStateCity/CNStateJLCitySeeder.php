<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateJLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 791,
'name' => 'Baicheng'
],[
'state_id' => 791,
'name' => 'Baishan'
],[
'state_id' => 791,
'name' => 'Baishishan'
],[
'state_id' => 791,
'name' => 'Changchun'
],[
'state_id' => 791,
'name' => 'Changling'
],[
'state_id' => 791,
'name' => 'Chaoyang'
],[
'state_id' => 791,
'name' => 'Dalai'
],[
'state_id' => 791,
'name' => 'Dashitou'
],[
'state_id' => 791,
'name' => 'Dehui'
],[
'state_id' => 791,
'name' => 'Dongfeng'
],[
'state_id' => 791,
'name' => 'Dunhua'
],[
'state_id' => 791,
'name' => 'Erdaojiang'
],[
'state_id' => 791,
'name' => 'Fuyu'
],[
'state_id' => 791,
'name' => 'Gongzhuling'
],[
'state_id' => 791,
'name' => 'Guangming'
],[
'state_id' => 791,
'name' => 'Helong'
],[
'state_id' => 791,
'name' => 'Hepingjie'
],[
'state_id' => 791,
'name' => 'Huadian'
],[
'state_id' => 791,
'name' => 'Huangnihe'
],[
'state_id' => 791,
'name' => 'Huinan'
],[
'state_id' => 791,
'name' => 'Hunchun'
],[
'state_id' => 791,
'name' => 'Jilin'
],[
'state_id' => 791,
'name' => 'Jishu'
],[
'state_id' => 791,
'name' => 'Jiutai'
],[
'state_id' => 791,
'name' => 'Ji’an'
],[
'state_id' => 791,
'name' => 'Kaitong'
],[
'state_id' => 791,
'name' => 'Liaoyuan'
],[
'state_id' => 791,
'name' => 'Linjiang'
],[
'state_id' => 791,
'name' => 'Lishu'
],[
'state_id' => 791,
'name' => 'Liuhe'
],[
'state_id' => 791,
'name' => 'Longjing'
],[
'state_id' => 791,
'name' => 'Meihekou'
],[
'state_id' => 791,
'name' => 'Mingyue'
],[
'state_id' => 791,
'name' => 'Minzhu'
],[
'state_id' => 791,
'name' => 'Panshi'
],[
'state_id' => 791,
'name' => 'Sanchazi'
],[
'state_id' => 791,
'name' => 'Shuangyang'
],[
'state_id' => 791,
'name' => 'Shulan'
],[
'state_id' => 791,
'name' => 'Siping'
],[
'state_id' => 791,
'name' => 'Songjianghe'
],[
'state_id' => 791,
'name' => 'Songyuan'
],[
'state_id' => 791,
'name' => 'Tonghua'
],[
'state_id' => 791,
'name' => 'Tonghua Shi'
],[
'state_id' => 791,
'name' => 'Tumen'
],[
'state_id' => 791,
'name' => 'Wangqing'
],[
'state_id' => 791,
'name' => 'Xinglongshan'
],[
'state_id' => 791,
'name' => 'Yanbian Chaoxianzu Zizhizhou'
],[
'state_id' => 791,
'name' => 'Yanji'
],[
'state_id' => 791,
'name' => 'Yantongshan'
],[
'state_id' => 791,
'name' => 'Yushu'
],[
'state_id' => 791,
'name' => 'Zhengjiatun'
],[
'state_id' => 791,
'name' => 'Zhenlai'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
