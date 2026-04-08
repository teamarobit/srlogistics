<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CIStateCMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 929,
'name' => 'Abengourou'
],[
'state_id' => 929,
'name' => 'Aboisso'
],[
'state_id' => 929,
'name' => 'Adiaké'
],[
'state_id' => 929,
'name' => 'Agnibilékrou'
],[
'state_id' => 929,
'name' => 'Ayamé'
],[
'state_id' => 929,
'name' => 'Bonoua'
],[
'state_id' => 929,
'name' => 'Grand-Bassam'
],[
'state_id' => 929,
'name' => 'Indénié-Djuablin'
],[
'state_id' => 929,
'name' => 'Sud-Comoé'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
