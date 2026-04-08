<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ALStateTRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 74,
'name' => 'Bashkia Kavajë'
],[
'state_id' => 74,
'name' => 'Bashkia Vorë'
],[
'state_id' => 74,
'name' => 'Kamëz'
],[
'state_id' => 74,
'name' => 'Kavajë'
],[
'state_id' => 74,
'name' => 'Krrabë'
],[
'state_id' => 74,
'name' => 'Rrethi i Kavajës'
],[
'state_id' => 74,
'name' => 'Rrethi i Tiranës'
],[
'state_id' => 74,
'name' => 'Rrogozhinë'
],[
'state_id' => 74,
'name' => 'Sinaballaj'
],[
'state_id' => 74,
'name' => 'Tirana'
],[
'state_id' => 74,
'name' => 'Vorë'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
