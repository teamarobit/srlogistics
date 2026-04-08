<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GHStateBOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1451,
'name' => 'Banda'
],[
'state_id' => 1451,
'name' => 'Berekum East'
],[
'state_id' => 1451,
'name' => 'Berekum West'
],[
'state_id' => 1451,
'name' => 'Dormaa Central'
],[
'state_id' => 1451,
'name' => 'Dormaa East'
],[
'state_id' => 1451,
'name' => 'Dormaa West'
],[
'state_id' => 1451,
'name' => 'Jaman North'
],[
'state_id' => 1451,
'name' => 'Jaman South'
],[
'state_id' => 1451,
'name' => 'Sunyani'
],[
'state_id' => 1451,
'name' => 'Sunyani West'
],[
'state_id' => 1451,
'name' => 'Tain'
],[
'state_id' => 1451,
'name' => 'Wenchi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
