<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BWStateKLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 516,
'name' => 'Bokaa'
],[
'state_id' => 516,
'name' => 'Mmathubudukwane'
],[
'state_id' => 516,
'name' => 'Mochudi'
],[
'state_id' => 516,
'name' => 'Pilane'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
