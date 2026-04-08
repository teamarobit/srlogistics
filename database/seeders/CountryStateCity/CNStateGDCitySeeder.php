<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateGDCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 817,
'name' => 'Anbu'
],[
'state_id' => 817,
'name' => 'Chaozhou'
],[
'state_id' => 817,
'name' => 'Chenghua'
],[
'state_id' => 817,
'name' => 'Daliang'
],[
'state_id' => 817,
'name' => 'Danshui'
],[
'state_id' => 817,
'name' => 'Dasha'
],[
'state_id' => 817,
'name' => 'Dongguan'
],[
'state_id' => 817,
'name' => 'Donghai'
],[
'state_id' => 817,
'name' => 'Ducheng'
],[
'state_id' => 817,
'name' => 'Encheng'
],[
'state_id' => 817,
'name' => 'Foshan'
],[
'state_id' => 817,
'name' => 'Foshan Shi'
],[
'state_id' => 817,
'name' => 'Gaoyao'
],[
'state_id' => 817,
'name' => 'Gaozhou'
],[
'state_id' => 817,
'name' => 'Guangzhou'
],[
'state_id' => 817,
'name' => 'Guangzhou Shi'
],[
'state_id' => 817,
'name' => 'Haikuotiankong'
],[
'state_id' => 817,
'name' => 'Haimen'
],[
'state_id' => 817,
'name' => 'Hepo'
],[
'state_id' => 817,
'name' => 'Heyuan'
],[
'state_id' => 817,
'name' => 'Huaicheng'
],[
'state_id' => 817,
'name' => 'Huanggang'
],[
'state_id' => 817,
'name' => 'Huazhou'
],[
'state_id' => 817,
'name' => 'Huicheng'
],[
'state_id' => 817,
'name' => 'Huizhou'
],[
'state_id' => 817,
'name' => 'Humen'
],[
'state_id' => 817,
'name' => 'Jiangmen'
],[
'state_id' => 817,
'name' => 'Jiazi'
],[
'state_id' => 817,
'name' => 'Jieshi'
],[
'state_id' => 817,
'name' => 'Jieyang'
],[
'state_id' => 817,
'name' => 'Lecheng'
],[
'state_id' => 817,
'name' => 'Lianjiang'
],[
'state_id' => 817,
'name' => 'Lianzhou'
],[
'state_id' => 817,
'name' => 'Licheng'
],[
'state_id' => 817,
'name' => 'Lubu'
],[
'state_id' => 817,
'name' => 'Luocheng'
],[
'state_id' => 817,
'name' => 'Luoyang'
],[
'state_id' => 817,
'name' => 'Maba'
],[
'state_id' => 817,
'name' => 'Maoming'
],[
'state_id' => 817,
'name' => 'Meizhou'
],[
'state_id' => 817,
'name' => 'Nanfeng'
],[
'state_id' => 817,
'name' => 'Pingshan'
],[
'state_id' => 817,
'name' => 'Puning'
],[
'state_id' => 817,
'name' => 'Qingyuan'
],[
'state_id' => 817,
'name' => 'Sanshui'
],[
'state_id' => 817,
'name' => 'Shantou'
],[
'state_id' => 817,
'name' => 'Shanwei'
],[
'state_id' => 817,
'name' => 'Shaoguan'
],[
'state_id' => 817,
'name' => 'Shaping'
],[
'state_id' => 817,
'name' => 'Shenzhen'
],[
'state_id' => 817,
'name' => 'Shilong'
],[
'state_id' => 817,
'name' => 'Shiqi'
],[
'state_id' => 817,
'name' => 'Shiqiao'
],[
'state_id' => 817,
'name' => 'Shiwan'
],[
'state_id' => 817,
'name' => 'Shixing'
],[
'state_id' => 817,
'name' => 'Taishan'
],[
'state_id' => 817,
'name' => 'Tangping'
],[
'state_id' => 817,
'name' => 'Wuchuan'
],[
'state_id' => 817,
'name' => 'Xingning'
],[
'state_id' => 817,
'name' => 'Xinhui'
],[
'state_id' => 817,
'name' => 'Xinyi'
],[
'state_id' => 817,
'name' => 'Xiongzhou'
],[
'state_id' => 817,
'name' => 'Xucheng'
],[
'state_id' => 817,
'name' => 'Yangchun'
],[
'state_id' => 817,
'name' => 'Yangjiang'
],[
'state_id' => 817,
'name' => 'Yingcheng'
],[
'state_id' => 817,
'name' => 'Yunfu'
],[
'state_id' => 817,
'name' => 'Zhanjiang'
],[
'state_id' => 817,
'name' => 'Zhaoqing'
],[
'state_id' => 817,
'name' => 'Zhongshan'
],[
'state_id' => 817,
'name' => 'Zhongshan Prefecture'
],[
'state_id' => 817,
'name' => 'Zhuhai'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
