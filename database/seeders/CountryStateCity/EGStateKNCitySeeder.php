<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateKNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1177,
'name' => 'Dishnā'
],[
'state_id' => 1177,
'name' => 'Farshūţ'
],[
'state_id' => 1177,
'name' => 'Isnā'
],[
'state_id' => 1177,
'name' => 'Kousa'
],[
'state_id' => 1177,
'name' => 'Naja\' Ḥammādī'
],[
'state_id' => 1177,
'name' => 'Qinā'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
