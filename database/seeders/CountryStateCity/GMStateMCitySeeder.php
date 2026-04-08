<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GMStateMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1407,
'name' => 'Bansang'
],[
'state_id' => 1407,
'name' => 'Brikama Nding'
],[
'state_id' => 1407,
'name' => 'Dankunku'
],[
'state_id' => 1407,
'name' => 'Denton'
],[
'state_id' => 1407,
'name' => 'Fulladu West'
],[
'state_id' => 1407,
'name' => 'Galleh Manda'
],[
'state_id' => 1407,
'name' => 'Georgetown'
],[
'state_id' => 1407,
'name' => 'Jakhaly'
],[
'state_id' => 1407,
'name' => 'Janjanbureh'
],[
'state_id' => 1407,
'name' => 'Jarreng'
],[
'state_id' => 1407,
'name' => 'Karantaba'
],[
'state_id' => 1407,
'name' => 'Kass Wollof'
],[
'state_id' => 1407,
'name' => 'Kuntaur'
],[
'state_id' => 1407,
'name' => 'Kunting'
],[
'state_id' => 1407,
'name' => 'Lower Saloum'
],[
'state_id' => 1407,
'name' => 'Niamina East District'
],[
'state_id' => 1407,
'name' => 'Niamina West District'
],[
'state_id' => 1407,
'name' => 'Niani'
],[
'state_id' => 1407,
'name' => 'Nianija District'
],[
'state_id' => 1407,
'name' => 'Pateh Sam'
],[
'state_id' => 1407,
'name' => 'Sami'
],[
'state_id' => 1407,
'name' => 'Sami District'
],[
'state_id' => 1407,
'name' => 'Saruja'
],[
'state_id' => 1407,
'name' => 'Sukuta'
],[
'state_id' => 1407,
'name' => 'Upper Saloum'
],[
'state_id' => 1407,
'name' => 'Wassu'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
