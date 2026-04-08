<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IQStateBACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1786,
'name' => 'Al Başrah al Qadīmah'
],[
'state_id' => 1786,
'name' => 'Al Fāw'
],[
'state_id' => 1786,
'name' => 'Al Hārithah'
],[
'state_id' => 1786,
'name' => 'Az Zubayr'
],[
'state_id' => 1786,
'name' => 'Basrah'
],[
'state_id' => 1786,
'name' => 'Umm Qaşr'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
