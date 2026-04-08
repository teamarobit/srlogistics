<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateGXCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 816,
'name' => 'Babu'
],[
'state_id' => 816,
'name' => 'Baihe'
],[
'state_id' => 816,
'name' => 'Baise City'
],[
'state_id' => 816,
'name' => 'Baise Shi'
],[
'state_id' => 816,
'name' => 'Beihai'
],[
'state_id' => 816,
'name' => 'Chongzuo Shi'
],[
'state_id' => 816,
'name' => 'Dazhai'
],[
'state_id' => 816,
'name' => 'Fangchenggang Shi'
],[
'state_id' => 816,
'name' => 'Guigang'
],[
'state_id' => 816,
'name' => 'Guilin'
],[
'state_id' => 816,
'name' => 'Guilin Shi'
],[
'state_id' => 816,
'name' => 'Guiping'
],[
'state_id' => 816,
'name' => 'Hechi Shi'
],[
'state_id' => 816,
'name' => 'Jinji'
],[
'state_id' => 816,
'name' => 'Laibin'
],[
'state_id' => 816,
'name' => 'Lianzhou'
],[
'state_id' => 816,
'name' => 'Lingcheng'
],[
'state_id' => 816,
'name' => 'Liuzhou Shi'
],[
'state_id' => 816,
'name' => 'Luorong'
],[
'state_id' => 816,
'name' => 'Nandu'
],[
'state_id' => 816,
'name' => 'Nanning'
],[
'state_id' => 816,
'name' => 'Pingnan'
],[
'state_id' => 816,
'name' => 'Pumiao'
],[
'state_id' => 816,
'name' => 'Qinzhou'
],[
'state_id' => 816,
'name' => 'Wuzhou'
],[
'state_id' => 816,
'name' => 'Yangshuo'
],[
'state_id' => 816,
'name' => 'Yashan'
],[
'state_id' => 816,
'name' => 'Yulin'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
