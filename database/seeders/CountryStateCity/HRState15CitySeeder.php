<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HRState15CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 937,
'name' => 'Brodarica'
],[
'state_id' => 937,
'name' => 'Drniš'
],[
'state_id' => 937,
'name' => 'Grad Drniš'
],[
'state_id' => 937,
'name' => 'Grad Šibenik'
],[
'state_id' => 937,
'name' => 'Kistanje'
],[
'state_id' => 937,
'name' => 'Knin'
],[
'state_id' => 937,
'name' => 'Murter'
],[
'state_id' => 937,
'name' => 'Murter-Kornati'
],[
'state_id' => 937,
'name' => 'Pirovac'
],[
'state_id' => 937,
'name' => 'Primošten'
],[
'state_id' => 937,
'name' => 'Promina'
],[
'state_id' => 937,
'name' => 'Rogoznica'
],[
'state_id' => 937,
'name' => 'Rogoznica Općina'
],[
'state_id' => 937,
'name' => 'Skradin'
],[
'state_id' => 937,
'name' => 'Tisno'
],[
'state_id' => 937,
'name' => 'Tribunj'
],[
'state_id' => 937,
'name' => 'Vodice'
],[
'state_id' => 937,
'name' => 'Šibenik'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
