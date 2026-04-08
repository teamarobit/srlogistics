<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState25CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 576,
'name' => 'Antonovo'
],[
'state_id' => 576,
'name' => 'Obshtina Antonovo'
],[
'state_id' => 576,
'name' => 'Obshtina Omurtag'
],[
'state_id' => 576,
'name' => 'Obshtina Opaka'
],[
'state_id' => 576,
'name' => 'Obshtina Popovo'
],[
'state_id' => 576,
'name' => 'Obshtina Targovishte'
],[
'state_id' => 576,
'name' => 'Omurtag'
],[
'state_id' => 576,
'name' => 'Opaka'
],[
'state_id' => 576,
'name' => 'Popovo'
],[
'state_id' => 576,
'name' => 'Targovishte'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
