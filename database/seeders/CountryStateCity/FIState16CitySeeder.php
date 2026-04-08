<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FIState16CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1261,
'name' => 'Artjärvi'
],[
'state_id' => 1261,
'name' => 'Asikkala'
],[
'state_id' => 1261,
'name' => 'Auttoinen'
],[
'state_id' => 1261,
'name' => 'Hartola'
],[
'state_id' => 1261,
'name' => 'Heinola'
],[
'state_id' => 1261,
'name' => 'Hollola'
],[
'state_id' => 1261,
'name' => 'Hämeenkoski'
],[
'state_id' => 1261,
'name' => 'Lahti'
],[
'state_id' => 1261,
'name' => 'Nastola'
],[
'state_id' => 1261,
'name' => 'Orimattila'
],[
'state_id' => 1261,
'name' => 'Padasjoki'
],[
'state_id' => 1261,
'name' => 'Sysmä'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
