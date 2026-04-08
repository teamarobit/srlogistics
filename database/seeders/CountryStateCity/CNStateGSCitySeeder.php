<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateGSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 813,
'name' => 'Baiyin'
],[
'state_id' => 813,
'name' => 'Beidao'
],[
'state_id' => 813,
'name' => 'Dingxi Shi'
],[
'state_id' => 813,
'name' => 'Hezuo'
],[
'state_id' => 813,
'name' => 'Jiayuguan'
],[
'state_id' => 813,
'name' => 'Jinchang'
],[
'state_id' => 813,
'name' => 'Jiuquan'
],[
'state_id' => 813,
'name' => 'Lanzhou'
],[
'state_id' => 813,
'name' => 'Laojunmiao'
],[
'state_id' => 813,
'name' => 'Linxia Chengguanzhen'
],[
'state_id' => 813,
'name' => 'Linxia Huizu Zizhizhou'
],[
'state_id' => 813,
'name' => 'Longnan Shi'
],[
'state_id' => 813,
'name' => 'Mawu'
],[
'state_id' => 813,
'name' => 'Pingliang'
],[
'state_id' => 813,
'name' => 'Qincheng'
],[
'state_id' => 813,
'name' => 'Qingyang Shi'
],[
'state_id' => 813,
'name' => 'Tianshui'
],[
'state_id' => 813,
'name' => 'Wuwei'
],[
'state_id' => 813,
'name' => 'Zhangye'
],[
'state_id' => 813,
'name' => 'Zhangye Shi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
