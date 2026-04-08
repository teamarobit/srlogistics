<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CAStateNUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 703,
'name' => 'Clyde River'
],[
'state_id' => 703,
'name' => 'Gjoa Haven'
],[
'state_id' => 703,
'name' => 'Iqaluit'
],[
'state_id' => 703,
'name' => 'Kugluktuk'
],[
'state_id' => 703,
'name' => 'Pangnirtung'
],[
'state_id' => 703,
'name' => 'Rankin Inlet'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
