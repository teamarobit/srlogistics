<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateCQCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 809,
'name' => 'Beibei'
],[
'state_id' => 809,
'name' => 'Caijia'
],[
'state_id' => 809,
'name' => 'Chongqing'
],[
'state_id' => 809,
'name' => 'Dongxi'
],[
'state_id' => 809,
'name' => 'Fuling'
],[
'state_id' => 809,
'name' => 'Ganshui'
],[
'state_id' => 809,
'name' => 'Guofuchang'
],[
'state_id' => 809,
'name' => 'Hechuan'
],[
'state_id' => 809,
'name' => 'Jijiang'
],[
'state_id' => 809,
'name' => 'Liangping District'
],[
'state_id' => 809,
'name' => 'Puhechang'
],[
'state_id' => 809,
'name' => 'Shapingba District'
],[
'state_id' => 809,
'name' => 'Shijiaochang'
],[
'state_id' => 809,
'name' => 'Wanxian'
],[
'state_id' => 809,
'name' => 'Wanzhou District'
],[
'state_id' => 809,
'name' => 'Yongchuan'
],[
'state_id' => 809,
'name' => 'Yudong'
],[
'state_id' => 809,
'name' => 'Yuzhong District'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
