<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateKFSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1152,
'name' => 'Al Ḩāmūl'
],[
'state_id' => 1152,
'name' => 'Disūq'
],[
'state_id' => 1152,
'name' => 'Fuwwah'
],[
'state_id' => 1152,
'name' => 'Kafr ash Shaykh'
],[
'state_id' => 1152,
'name' => 'Markaz Disūq'
],[
'state_id' => 1152,
'name' => 'Munshāt ‘Alī Āghā'
],[
'state_id' => 1152,
'name' => 'Sīdī Sālim'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
