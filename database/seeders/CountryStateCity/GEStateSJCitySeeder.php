<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GEStateSJCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1419,
'name' => 'Adigeni'
],[
'state_id' => 1419,
'name' => 'Adigeni Municipality'
],[
'state_id' => 1419,
'name' => 'Akhaldaba'
],[
'state_id' => 1419,
'name' => 'Akhalk’alak’i'
],[
'state_id' => 1419,
'name' => 'Akhaltsikhe'
],[
'state_id' => 1419,
'name' => 'Akhaltsikhis Munitsip’alit’et’i'
],[
'state_id' => 1419,
'name' => 'Aspindza'
],[
'state_id' => 1419,
'name' => 'Asp’indzis Munitsip’alit’et’i'
],[
'state_id' => 1419,
'name' => 'Bakuriani'
],[
'state_id' => 1419,
'name' => 'Borjomi'
],[
'state_id' => 1419,
'name' => 'Ninotsminda'
],[
'state_id' => 1419,
'name' => 'Tsaghveri'
],[
'state_id' => 1419,
'name' => 'Vale'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
