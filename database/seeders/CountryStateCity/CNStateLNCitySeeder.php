<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateLNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 806,
'name' => 'Anshan'
],[
'state_id' => 806,
'name' => 'Beipiao'
],[
'state_id' => 806,
'name' => 'Benxi'
],[
'state_id' => 806,
'name' => 'Changtu'
],[
'state_id' => 806,
'name' => 'Chaoyang'
],[
'state_id' => 806,
'name' => 'Dalian'
],[
'state_id' => 806,
'name' => 'Dalianwan'
],[
'state_id' => 806,
'name' => 'Dandong'
],[
'state_id' => 806,
'name' => 'Dashiqiao'
],[
'state_id' => 806,
'name' => 'Dongling'
],[
'state_id' => 806,
'name' => 'Fengcheng'
],[
'state_id' => 806,
'name' => 'Fushun'
],[
'state_id' => 806,
'name' => 'Fuxin'
],[
'state_id' => 806,
'name' => 'Gaizhou'
],[
'state_id' => 806,
'name' => 'Gongchangling'
],[
'state_id' => 806,
'name' => 'Haicheng'
],[
'state_id' => 806,
'name' => 'Heishan'
],[
'state_id' => 806,
'name' => 'Huanren'
],[
'state_id' => 806,
'name' => 'Huludao'
],[
'state_id' => 806,
'name' => 'Huludao Shi'
],[
'state_id' => 806,
'name' => 'Hushitai'
],[
'state_id' => 806,
'name' => 'Jinzhou'
],[
'state_id' => 806,
'name' => 'Jiupu'
],[
'state_id' => 806,
'name' => 'Kaiyuan'
],[
'state_id' => 806,
'name' => 'Kuandian'
],[
'state_id' => 806,
'name' => 'Langtoucun'
],[
'state_id' => 806,
'name' => 'Lianshan'
],[
'state_id' => 806,
'name' => 'Liaoyang'
],[
'state_id' => 806,
'name' => 'Liaozhong'
],[
'state_id' => 806,
'name' => 'Linghai'
],[
'state_id' => 806,
'name' => 'Lingyuan'
],[
'state_id' => 806,
'name' => 'Lüshun'
],[
'state_id' => 806,
'name' => 'Nanpiao'
],[
'state_id' => 806,
'name' => 'Nantai'
],[
'state_id' => 806,
'name' => 'Panjin Shi'
],[
'state_id' => 806,
'name' => 'Panshan'
],[
'state_id' => 806,
'name' => 'Pulandian'
],[
'state_id' => 806,
'name' => 'Shenyang'
],[
'state_id' => 806,
'name' => 'Sujiatun'
],[
'state_id' => 806,
'name' => 'Tieling'
],[
'state_id' => 806,
'name' => 'Tieling Shi'
],[
'state_id' => 806,
'name' => 'Wafangdian'
],[
'state_id' => 806,
'name' => 'Xiaoshi'
],[
'state_id' => 806,
'name' => 'Xifeng'
],[
'state_id' => 806,
'name' => 'Xingcheng'
],[
'state_id' => 806,
'name' => 'Xinmin'
],[
'state_id' => 806,
'name' => 'Xinxing'
],[
'state_id' => 806,
'name' => 'Xiuyan'
],[
'state_id' => 806,
'name' => 'Yebaishou'
],[
'state_id' => 806,
'name' => 'Yingkou'
],[
'state_id' => 806,
'name' => 'Zhuanghe'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
