<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateGHCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1164,
'name' => 'Al Maḩallah al Kubrá'
],[
'state_id' => 1164,
'name' => 'Basyūn'
],[
'state_id' => 1164,
'name' => 'Kafr az Zayyāt'
],[
'state_id' => 1164,
'name' => 'Quţūr'
],[
'state_id' => 1164,
'name' => 'Samannūd'
],[
'state_id' => 1164,
'name' => 'Tanda'
],[
'state_id' => 1164,
'name' => 'Zefta'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
