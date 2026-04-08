<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ERStateDUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1205,
'name' => 'Adi Keyh'
],[
'state_id' => 1205,
'name' => 'Dek’emhāre'
],[
'state_id' => 1205,
'name' => 'Mendefera'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
