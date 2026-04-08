<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EEState65CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1216,
'name' => 'Kanepi'
],[
'state_id' => 1216,
'name' => 'Kanepi vald'
],[
'state_id' => 1216,
'name' => 'Põlva'
],[
'state_id' => 1216,
'name' => 'Põlva vald'
],[
'state_id' => 1216,
'name' => 'Räpina'
],[
'state_id' => 1216,
'name' => 'Räpina vald'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
