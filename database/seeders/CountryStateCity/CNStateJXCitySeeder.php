<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateJXCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 794,
'name' => 'Changleng'
],[
'state_id' => 794,
'name' => 'Fenyi'
],[
'state_id' => 794,
'name' => 'Ganzhou'
],[
'state_id' => 794,
'name' => 'Ganzhou Shi'
],[
'state_id' => 794,
'name' => 'Guixi'
],[
'state_id' => 794,
'name' => 'Jianguang'
],[
'state_id' => 794,
'name' => 'Jingdezhen'
],[
'state_id' => 794,
'name' => 'Jingdezhen Shi'
],[
'state_id' => 794,
'name' => 'Jiujiang'
],[
'state_id' => 794,
'name' => 'Ji’an'
],[
'state_id' => 794,
'name' => 'Nanchang'
],[
'state_id' => 794,
'name' => 'Pingxiang'
],[
'state_id' => 794,
'name' => 'Poyang'
],[
'state_id' => 794,
'name' => 'Shangrao'
],[
'state_id' => 794,
'name' => 'Xinyu'
],[
'state_id' => 794,
'name' => 'Yichun'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
