<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TDStateCBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 768,
'name' => 'Baguirmi Department'
],[
'state_id' => 768,
'name' => 'Bousso'
],[
'state_id' => 768,
'name' => 'Chari Department'
],[
'state_id' => 768,
'name' => 'Dababa'
],[
'state_id' => 768,
'name' => 'Gaoui'
],[
'state_id' => 768,
'name' => 'Linia'
],[
'state_id' => 768,
'name' => 'Mandjafa'
],[
'state_id' => 768,
'name' => 'Massenya'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
