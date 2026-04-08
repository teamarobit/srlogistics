<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateBACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1170,
'name' => 'Al Quşayr'
],[
'state_id' => 1170,
'name' => 'El Gouna'
],[
'state_id' => 1170,
'name' => 'Hurghada'
],[
'state_id' => 1170,
'name' => 'Makadi Bay'
],[
'state_id' => 1170,
'name' => 'Marsa Alam'
],[
'state_id' => 1170,
'name' => 'Ras Gharib'
],[
'state_id' => 1170,
'name' => 'Safaga'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
