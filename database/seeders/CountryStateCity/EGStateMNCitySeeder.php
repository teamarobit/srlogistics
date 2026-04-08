<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateMNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1173,
'name' => 'Abū Qurqāş'
],[
'state_id' => 1173,
'name' => 'Al Minyā'
],[
'state_id' => 1173,
'name' => 'Banī Mazār'
],[
'state_id' => 1173,
'name' => 'Dayr Mawās'
],[
'state_id' => 1173,
'name' => 'Mallawī'
],[
'state_id' => 1173,
'name' => 'Maţāy'
],[
'state_id' => 1173,
'name' => 'Samālūţ'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
