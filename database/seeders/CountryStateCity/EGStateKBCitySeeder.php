<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateKBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1162,
'name' => 'Al Khānkah'
],[
'state_id' => 1162,
'name' => 'Al Qanāţir al Khayrīyah'
],[
'state_id' => 1162,
'name' => 'Banhā'
],[
'state_id' => 1162,
'name' => 'Qalyūb'
],[
'state_id' => 1162,
'name' => 'Shibīn al Qanāṭir'
],[
'state_id' => 1162,
'name' => 'Toukh'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
