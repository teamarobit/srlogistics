<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateHNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 796,
'name' => 'Anjiang'
],[
'state_id' => 796,
'name' => 'Anping'
],[
'state_id' => 796,
'name' => 'Anxiang'
],[
'state_id' => 796,
'name' => 'Baisha'
],[
'state_id' => 796,
'name' => 'Biyong'
],[
'state_id' => 796,
'name' => 'Bojia'
],[
'state_id' => 796,
'name' => 'Boyang'
],[
'state_id' => 796,
'name' => 'Bozhou'
],[
'state_id' => 796,
'name' => 'Changde'
],[
'state_id' => 796,
'name' => 'Changsha'
],[
'state_id' => 796,
'name' => 'Changsha Shi'
],[
'state_id' => 796,
'name' => 'Chatian'
],[
'state_id' => 796,
'name' => 'Chenzhou'
],[
'state_id' => 796,
'name' => 'Dabaozi'
],[
'state_id' => 796,
'name' => 'Dehang'
],[
'state_id' => 796,
'name' => 'Dengjiapu'
],[
'state_id' => 796,
'name' => 'Dengyuantai'
],[
'state_id' => 796,
'name' => 'Dongshan Dongzuxiang'
],[
'state_id' => 796,
'name' => 'Fenghuang'
],[
'state_id' => 796,
'name' => 'Gangdong'
],[
'state_id' => 796,
'name' => 'Gaoqiao'
],[
'state_id' => 796,
'name' => 'Gaoyi'
],[
'state_id' => 796,
'name' => 'Guankou'
],[
'state_id' => 796,
'name' => 'Hengbanqiao'
],[
'state_id' => 796,
'name' => 'Hengyang'
],[
'state_id' => 796,
'name' => 'Hexiangqiao'
],[
'state_id' => 796,
'name' => 'Hongjiang'
],[
'state_id' => 796,
'name' => 'Hongqiao'
],[
'state_id' => 796,
'name' => 'Huaihua'
],[
'state_id' => 796,
'name' => 'Huangjinjing'
],[
'state_id' => 796,
'name' => 'Huanglong'
],[
'state_id' => 796,
'name' => 'Huangmaoyuan'
],[
'state_id' => 796,
'name' => 'Huangqiao'
],[
'state_id' => 796,
'name' => 'Huangtukuang'
],[
'state_id' => 796,
'name' => 'Huangxikou'
],[
'state_id' => 796,
'name' => 'Huaqiao'
],[
'state_id' => 796,
'name' => 'Huayuan'
],[
'state_id' => 796,
'name' => 'Huomachong'
],[
'state_id' => 796,
'name' => 'Jiangfang'
],[
'state_id' => 796,
'name' => 'Jiangkouxu'
],[
'state_id' => 796,
'name' => 'Jiangshi'
],[
'state_id' => 796,
'name' => 'Jinhe'
],[
'state_id' => 796,
'name' => 'Jinshi'
],[
'state_id' => 796,
'name' => 'Jinshiqiao'
],[
'state_id' => 796,
'name' => 'Lanli'
],[
'state_id' => 796,
'name' => 'Leiyang'
],[
'state_id' => 796,
'name' => 'Lengshuijiang'
],[
'state_id' => 796,
'name' => 'Lengshuitan'
],[
'state_id' => 796,
'name' => 'Liangyaping'
],[
'state_id' => 796,
'name' => 'Lianyuan'
],[
'state_id' => 796,
'name' => 'Linkou'
],[
'state_id' => 796,
'name' => 'Liuduzhai'
],[
'state_id' => 796,
'name' => 'Lixiqiao'
],[
'state_id' => 796,
'name' => 'Longtan'
],[
'state_id' => 796,
'name' => 'Longtou’an'
],[
'state_id' => 796,
'name' => 'Loudi'
],[
'state_id' => 796,
'name' => 'Luojiu'
],[
'state_id' => 796,
'name' => 'Luyang'
],[
'state_id' => 796,
'name' => 'Malin'
],[
'state_id' => 796,
'name' => 'Maoping'
],[
'state_id' => 796,
'name' => 'Ma’an'
],[
'state_id' => 796,
'name' => 'Nanmuping'
],[
'state_id' => 796,
'name' => 'Nanzhou'
],[
'state_id' => 796,
'name' => 'Prefecture of Chenzhou'
],[
'state_id' => 796,
'name' => 'Pukou'
],[
'state_id' => 796,
'name' => 'Puzi'
],[
'state_id' => 796,
'name' => 'Qiancheng'
],[
'state_id' => 796,
'name' => 'Qianzhou'
],[
'state_id' => 796,
'name' => 'Qiaojiang'
],[
'state_id' => 796,
'name' => 'Qingjiangqiao'
],[
'state_id' => 796,
'name' => 'Qingxi'
],[
'state_id' => 796,
'name' => 'Qionghu'
],[
'state_id' => 796,
'name' => 'Ruoshui'
],[
'state_id' => 796,
'name' => 'Shangmei'
],[
'state_id' => 796,
'name' => 'Shanmen'
],[
'state_id' => 796,
'name' => 'Shijiang'
],[
'state_id' => 796,
'name' => 'Shuangjiang'
],[
'state_id' => 796,
'name' => 'Shuangxi'
],[
'state_id' => 796,
'name' => 'Shuiche'
],[
'state_id' => 796,
'name' => 'Shuidatian'
],[
'state_id' => 796,
'name' => 'Simenqian'
],[
'state_id' => 796,
'name' => 'Tangjiafang'
],[
'state_id' => 796,
'name' => 'Tanwan'
],[
'state_id' => 796,
'name' => 'Tongwan'
],[
'state_id' => 796,
'name' => 'Tuokou'
],[
'state_id' => 796,
'name' => 'Wantouqiao'
],[
'state_id' => 796,
'name' => 'Wenxing'
],[
'state_id' => 796,
'name' => 'Wulingyuan'
],[
'state_id' => 796,
'name' => 'Wuxi'
],[
'state_id' => 796,
'name' => 'Wuyang'
],[
'state_id' => 796,
'name' => 'Xiangtan'
],[
'state_id' => 796,
'name' => 'Xiangxi Tujiazu Miaozu Zizhizhou'
],[
'state_id' => 796,
'name' => 'Xiangxiang'
],[
'state_id' => 796,
'name' => 'Xianrenwan'
],[
'state_id' => 796,
'name' => 'Xianxi'
],[
'state_id' => 796,
'name' => 'Xiaohenglong'
],[
'state_id' => 796,
'name' => 'Xiaolongmen'
],[
'state_id' => 796,
'name' => 'Xiaoshajiang'
],[
'state_id' => 796,
'name' => 'Xishan'
],[
'state_id' => 796,
'name' => 'Xixi'
],[
'state_id' => 796,
'name' => 'Xiyan'
],[
'state_id' => 796,
'name' => 'Yanmen'
],[
'state_id' => 796,
'name' => 'Yaoshi'
],[
'state_id' => 796,
'name' => 'Yatunpu'
],[
'state_id' => 796,
'name' => 'Yiyang'
],[
'state_id' => 796,
'name' => 'Yongfeng'
],[
'state_id' => 796,
'name' => 'Yongzhou'
],[
'state_id' => 796,
'name' => 'Yueyang'
],[
'state_id' => 796,
'name' => 'Yueyang Shi'
],[
'state_id' => 796,
'name' => 'Yutan'
],[
'state_id' => 796,
'name' => 'Zhaishi Miaozu Dongzuxiang'
],[
'state_id' => 796,
'name' => 'Zhangjiajie'
],[
'state_id' => 796,
'name' => 'Zhongfang'
],[
'state_id' => 796,
'name' => 'Zhongzhai'
],[
'state_id' => 796,
'name' => 'Zhushi'
],[
'state_id' => 796,
'name' => 'Zhuzhou'
],[
'state_id' => 796,
'name' => 'Zhuzhou Shi'
],[
'state_id' => 796,
'name' => 'Zhuzhoujiang Miaozuxiang'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
