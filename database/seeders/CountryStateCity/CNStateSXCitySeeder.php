<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateSXCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 792,
'name' => 'Changzhi'
],[
'state_id' => 792,
'name' => 'Datong'
],[
'state_id' => 792,
'name' => 'Datong Shi'
],[
'state_id' => 792,
'name' => 'Gutao'
],[
'state_id' => 792,
'name' => 'Jiexiu'
],[
'state_id' => 792,
'name' => 'Jincheng'
],[
'state_id' => 792,
'name' => 'Jinzhong Shi'
],[
'state_id' => 792,
'name' => 'Linfen'
],[
'state_id' => 792,
'name' => 'Lüliang'
],[
'state_id' => 792,
'name' => 'Shuozhou'
],[
'state_id' => 792,
'name' => 'Taiyuan'
],[
'state_id' => 792,
'name' => 'Xintian'
],[
'state_id' => 792,
'name' => 'Xinzhi'
],[
'state_id' => 792,
'name' => 'Xinzhou'
],[
'state_id' => 792,
'name' => 'Yangquan'
],[
'state_id' => 792,
'name' => 'Yuanping'
],[
'state_id' => 792,
'name' => 'Yuci'
],[
'state_id' => 792,
'name' => 'Yuncheng'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
