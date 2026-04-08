<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EEState57CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1221,
'name' => 'Haapsalu'
],[
'state_id' => 1221,
'name' => 'Haapsalu linn'
],[
'state_id' => 1221,
'name' => 'Hullo'
],[
'state_id' => 1221,
'name' => 'Lääne-Nigula vald'
],[
'state_id' => 1221,
'name' => 'Taebla'
],[
'state_id' => 1221,
'name' => 'Uuemõisa'
],[
'state_id' => 1221,
'name' => 'Vormsi vald'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
