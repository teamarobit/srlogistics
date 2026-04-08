<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CYState02CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 972,
'name' => 'Erími'
],[
'state_id' => 972,
'name' => 'Germasógeia'
],[
'state_id' => 972,
'name' => 'Kyperoúnta'
],[
'state_id' => 972,
'name' => 'Lemesós'
],[
'state_id' => 972,
'name' => 'Limassol'
],[
'state_id' => 972,
'name' => 'Mouttagiáka'
],[
'state_id' => 972,
'name' => 'Parekklisha'
],[
'state_id' => 972,
'name' => 'Peléndri'
],[
'state_id' => 972,
'name' => 'Pissoúri'
],[
'state_id' => 972,
'name' => 'Pyrgos'
],[
'state_id' => 972,
'name' => 'Páchna'
],[
'state_id' => 972,
'name' => 'Páno Polemídia'
],[
'state_id' => 972,
'name' => 'Sotíra'
],[
'state_id' => 972,
'name' => 'Soúni-Zanakiá'
],[
'state_id' => 972,
'name' => 'Ágios Tomás'
],[
'state_id' => 972,
'name' => 'Ýpsonas'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
