<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BRStateRRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 550,
'name' => 'Amajari'
],[
'state_id' => 550,
'name' => 'Boa Vista'
],[
'state_id' => 550,
'name' => 'Bonfim'
],[
'state_id' => 550,
'name' => 'Cantá'
],[
'state_id' => 550,
'name' => 'Caracaraí'
],[
'state_id' => 550,
'name' => 'Caroebe'
],[
'state_id' => 550,
'name' => 'Iracema'
],[
'state_id' => 550,
'name' => 'Mucajaí'
],[
'state_id' => 550,
'name' => 'Normandia'
],[
'state_id' => 550,
'name' => 'Pacaraima'
],[
'state_id' => 550,
'name' => 'Rorainópolis'
],[
'state_id' => 550,
'name' => 'São João da Baliza'
],[
'state_id' => 550,
'name' => 'São Luís'
],[
'state_id' => 550,
'name' => 'Uiramutã'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
