<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BWStateNECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 522,
'name' => 'Dukwe'
],[
'state_id' => 522,
'name' => 'Makaleng'
],[
'state_id' => 522,
'name' => 'Masunga'
],[
'state_id' => 522,
'name' => 'Sebina'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
