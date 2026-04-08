<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AFStateNIMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 27,
'name' => 'Khāsh'
],[
'state_id' => 27,
'name' => 'Mīrābād'
],[
'state_id' => 27,
'name' => 'Rūdbār'
],[
'state_id' => 27,
'name' => 'Zaranj'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
