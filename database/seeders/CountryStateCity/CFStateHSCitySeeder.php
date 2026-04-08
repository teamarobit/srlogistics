<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CFStateHSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 734,
'name' => 'Berberati'
],[
'state_id' => 734,
'name' => 'Carnot'
],[
'state_id' => 734,
'name' => 'Gamboula'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
