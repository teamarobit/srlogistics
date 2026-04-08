<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BJStateBOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 460,
'name' => 'Bembèrèkè'
],[
'state_id' => 460,
'name' => 'Bétérou'
],[
'state_id' => 460,
'name' => 'Nikki'
],[
'state_id' => 460,
'name' => 'Parakou'
],[
'state_id' => 460,
'name' => 'Tchaourou'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
