<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateHECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 818,
'name' => 'Baoding'
],[
'state_id' => 818,
'name' => 'Beidaihehaibin'
],[
'state_id' => 818,
'name' => 'Botou'
],[
'state_id' => 818,
'name' => 'Cangzhou'
],[
'state_id' => 818,
'name' => 'Cangzhou Shi'
],[
'state_id' => 818,
'name' => 'Changli'
],[
'state_id' => 818,
'name' => 'Chengde'
],[
'state_id' => 818,
'name' => 'Chengde Prefecture'
],[
'state_id' => 818,
'name' => 'Dingzhou'
],[
'state_id' => 818,
'name' => 'Fengrun'
],[
'state_id' => 818,
'name' => 'Guye'
],[
'state_id' => 818,
'name' => 'Handan'
],[
'state_id' => 818,
'name' => 'Hecun'
],[
'state_id' => 818,
'name' => 'Hengshui'
],[
'state_id' => 818,
'name' => 'Langfang'
],[
'state_id' => 818,
'name' => 'Langfang Shi'
],[
'state_id' => 818,
'name' => 'Linshui'
],[
'state_id' => 818,
'name' => 'Linxi'
],[
'state_id' => 818,
'name' => 'Luancheng'
],[
'state_id' => 818,
'name' => 'Nangong'
],[
'state_id' => 818,
'name' => 'Pengcheng'
],[
'state_id' => 818,
'name' => 'Qinhuangdao'
],[
'state_id' => 818,
'name' => 'Renqiu'
],[
'state_id' => 818,
'name' => 'Shahecheng'
],[
'state_id' => 818,
'name' => 'Shanhaiguan'
],[
'state_id' => 818,
'name' => 'Shijiazhuang'
],[
'state_id' => 818,
'name' => 'Shijiazhuang Shi'
],[
'state_id' => 818,
'name' => 'Songling'
],[
'state_id' => 818,
'name' => 'Tangjiazhuang'
],[
'state_id' => 818,
'name' => 'Tangshan'
],[
'state_id' => 818,
'name' => 'Tangshan Shi'
],[
'state_id' => 818,
'name' => 'Tianchang'
],[
'state_id' => 818,
'name' => 'Xingtai'
],[
'state_id' => 818,
'name' => 'Xinji'
],[
'state_id' => 818,
'name' => 'Zhangjiakou'
],[
'state_id' => 818,
'name' => 'Zhangjiakou Shi'
],[
'state_id' => 818,
'name' => 'Zhangjiakou Shi Xuanhua Qu'
],[
'state_id' => 818,
'name' => 'Zhaogezhuang'
],[
'state_id' => 818,
'name' => 'Zunhua'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
