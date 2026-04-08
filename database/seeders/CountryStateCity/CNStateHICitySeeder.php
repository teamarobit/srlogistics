<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateHICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 811,
'name' => 'Basuo'
],[
'state_id' => 811,
'name' => 'Chongshan'
],[
'state_id' => 811,
'name' => 'Dadonghai'
],[
'state_id' => 811,
'name' => 'Haikou'
],[
'state_id' => 811,
'name' => 'Jinjiang'
],[
'state_id' => 811,
'name' => 'Lincheng'
],[
'state_id' => 811,
'name' => 'Nada'
],[
'state_id' => 811,
'name' => 'Qionghai'
],[
'state_id' => 811,
'name' => 'Qiongshan'
],[
'state_id' => 811,
'name' => 'Sansha'
],[
'state_id' => 811,
'name' => 'Sanya'
],[
'state_id' => 811,
'name' => 'Wanning'
],[
'state_id' => 811,
'name' => 'Wenchang'
],[
'state_id' => 811,
'name' => 'Xiuying'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
