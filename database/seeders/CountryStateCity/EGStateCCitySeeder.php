<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateCCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1153,
'name' => 'Cairo'
],[
'state_id' => 1153,
'name' => 'Badr'
],[
'state_id' => 1153,
'name' => 'Bulaq'
],[
'state_id' => 1153,
'name' => 'El Mataria'
],[
'state_id' => 1153,
'name' => 'Fustat'
],[
'state_id' => 1153,
'name' => 'Hadayek El Kobba'
],[
'state_id' => 1153,
'name' => 'Heliopolis'
],[
'state_id' => 1153,
'name' => 'Helwan'
],[
'state_id' => 1153,
'name' => 'Maadi'
],[
'state_id' => 1153,
'name' => 'Musturud'
],[
'state_id' => 1153,
'name' => 'New Administrative Capital of Egypt'
],[
'state_id' => 1153,
'name' => 'Shubra'
],[
'state_id' => 1153,
'name' => 'Tura'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
