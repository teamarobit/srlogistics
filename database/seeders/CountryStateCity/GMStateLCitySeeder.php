<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GMStateLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1408,
'name' => 'Baro Kunda'
],[
'state_id' => 1408,
'name' => 'Bureng'
],[
'state_id' => 1408,
'name' => 'Jali'
],[
'state_id' => 1408,
'name' => 'Jarra Central'
],[
'state_id' => 1408,
'name' => 'Jarra East'
],[
'state_id' => 1408,
'name' => 'Jarra West'
],[
'state_id' => 1408,
'name' => 'Jenoi'
],[
'state_id' => 1408,
'name' => 'Jifarong'
],[
'state_id' => 1408,
'name' => 'Kaiaf'
],[
'state_id' => 1408,
'name' => 'Karantaba'
],[
'state_id' => 1408,
'name' => 'Keneba'
],[
'state_id' => 1408,
'name' => 'Kiang Central'
],[
'state_id' => 1408,
'name' => 'Kiang East'
],[
'state_id' => 1408,
'name' => 'Kiang West District'
],[
'state_id' => 1408,
'name' => 'Mansa Konko'
],[
'state_id' => 1408,
'name' => 'Nioro'
],[
'state_id' => 1408,
'name' => 'Sankwia'
],[
'state_id' => 1408,
'name' => 'Si Kunda'
],[
'state_id' => 1408,
'name' => 'Soma'
],[
'state_id' => 1408,
'name' => 'Sutukung'
],[
'state_id' => 1408,
'name' => 'Toniataba'
],[
'state_id' => 1408,
'name' => 'Wellingara Ba'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
