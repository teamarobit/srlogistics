<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GEStateAJCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1413,
'name' => 'Akhaldaba'
],[
'state_id' => 1413,
'name' => 'Batumi'
],[
'state_id' => 1413,
'name' => 'Chakvi'
],[
'state_id' => 1413,
'name' => 'Dioknisi'
],[
'state_id' => 1413,
'name' => 'Khelvachauri'
],[
'state_id' => 1413,
'name' => 'Khulo'
],[
'state_id' => 1413,
'name' => 'Kobuleti'
],[
'state_id' => 1413,
'name' => 'Makhinjauri'
],[
'state_id' => 1413,
'name' => 'Ochkhamuri'
],[
'state_id' => 1413,
'name' => 'Shuakhevi'
],[
'state_id' => 1413,
'name' => 'Tsikhisdziri'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
