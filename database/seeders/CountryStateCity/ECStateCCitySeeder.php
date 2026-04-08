<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ECStateCCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1138,
'name' => 'El Ángel'
],[
'state_id' => 1138,
'name' => 'San Gabriel'
],[
'state_id' => 1138,
'name' => 'Tulcán'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
