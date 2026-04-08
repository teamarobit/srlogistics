<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CNStateNMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 807,
'name' => 'Baotou'
],[
'state_id' => 807,
'name' => 'Bayan Nur'
],[
'state_id' => 807,
'name' => 'Bayannur Shi'
],[
'state_id' => 807,
'name' => 'Beichengqu'
],[
'state_id' => 807,
'name' => 'Chifeng'
],[
'state_id' => 807,
'name' => 'Dongsheng'
],[
'state_id' => 807,
'name' => 'Erenhot'
],[
'state_id' => 807,
'name' => 'E’erguna'
],[
'state_id' => 807,
'name' => 'Genhe'
],[
'state_id' => 807,
'name' => 'Hailar'
],[
'state_id' => 807,
'name' => 'Hohhot'
],[
'state_id' => 807,
'name' => 'Hulunbuir Region'
],[
'state_id' => 807,
'name' => 'Jalai Nur'
],[
'state_id' => 807,
'name' => 'Jiagedaqi'
],[
'state_id' => 807,
'name' => 'Jining'
],[
'state_id' => 807,
'name' => 'Manzhouli'
],[
'state_id' => 807,
'name' => 'Mositai'
],[
'state_id' => 807,
'name' => 'Mujiayingzi'
],[
'state_id' => 807,
'name' => 'Ordos'
],[
'state_id' => 807,
'name' => 'Ordos Shi'
],[
'state_id' => 807,
'name' => 'Oroqen Zizhiqi'
],[
'state_id' => 807,
'name' => 'Pingzhuang'
],[
'state_id' => 807,
'name' => 'Salaqi'
],[
'state_id' => 807,
'name' => 'Shiguai'
],[
'state_id' => 807,
'name' => 'Tongliao'
],[
'state_id' => 807,
'name' => 'Ulanhot'
],[
'state_id' => 807,
'name' => 'Wenquan'
],[
'state_id' => 807,
'name' => 'Wuda'
],[
'state_id' => 807,
'name' => 'Wuhai'
],[
'state_id' => 807,
'name' => 'Xilin Gol Meng'
],[
'state_id' => 807,
'name' => 'Xilin Hot'
],[
'state_id' => 807,
'name' => 'Yakeshi'
],[
'state_id' => 807,
'name' => 'Zhalantun'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
