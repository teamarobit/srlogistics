<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ECStateSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1141,
'name' => 'Gualaquiza'
],[
'state_id' => 1141,
'name' => 'Macas'
],[
'state_id' => 1141,
'name' => 'Palora'
],[
'state_id' => 1141,
'name' => 'Sucúa'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
