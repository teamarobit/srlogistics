<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KHState1CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 670,
'name' => 'Mongkol Borei'
],[
'state_id' => 670,
'name' => 'Paoy Paet'
],[
'state_id' => 670,
'name' => 'Sisophon'
],[
'state_id' => 670,
'name' => 'Srŏk Malai'
],[
'state_id' => 670,
'name' => 'Srŏk Svay Chék'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
