<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState16CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1100,
'name' => 'Juancho'
],[
'state_id' => 1100,
'name' => 'Oviedo'
],[
'state_id' => 1100,
'name' => 'Pedernales'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
