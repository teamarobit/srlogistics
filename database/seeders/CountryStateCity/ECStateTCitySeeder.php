<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ECStateTCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1131,
'name' => 'Ambato'
],[
'state_id' => 1131,
'name' => 'Baños'
],[
'state_id' => 1131,
'name' => 'Pelileo'
],[
'state_id' => 1131,
'name' => 'Píllaro'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
