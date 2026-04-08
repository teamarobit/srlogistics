<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState07CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 555,
'name' => 'Dryanovo'
],[
'state_id' => 555,
'name' => 'Gabrovo'
],[
'state_id' => 555,
'name' => 'Obshtina Dryanovo'
],[
'state_id' => 555,
'name' => 'Obshtina Gabrovo'
],[
'state_id' => 555,
'name' => 'Obshtina Sevlievo'
],[
'state_id' => 555,
'name' => 'Obshtina Tryavna'
],[
'state_id' => 555,
'name' => 'Sevlievo'
],[
'state_id' => 555,
'name' => 'Tryavna'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
