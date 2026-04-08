<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CAStatePECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 698,
'name' => 'Alberton'
],[
'state_id' => 698,
'name' => 'Belfast'
],[
'state_id' => 698,
'name' => 'Charlottetown'
],[
'state_id' => 698,
'name' => 'Cornwall'
],[
'state_id' => 698,
'name' => 'Fallingbrook'
],[
'state_id' => 698,
'name' => 'Kensington'
],[
'state_id' => 698,
'name' => 'Montague'
],[
'state_id' => 698,
'name' => 'Souris'
],[
'state_id' => 698,
'name' => 'Summerside'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
