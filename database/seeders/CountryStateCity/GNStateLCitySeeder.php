<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GNStateLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1527,
'name' => 'Koubia'
],[
'state_id' => 1527,
'name' => 'Labe Prefecture'
],[
'state_id' => 1527,
'name' => 'Labé'
],[
'state_id' => 1527,
'name' => 'Lelouma Prefecture'
],[
'state_id' => 1527,
'name' => 'Lélouma'
],[
'state_id' => 1527,
'name' => 'Mali'
],[
'state_id' => 1527,
'name' => 'Mali Prefecture'
],[
'state_id' => 1527,
'name' => 'Tougue Prefecture'
],[
'state_id' => 1527,
'name' => 'Tougué'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
