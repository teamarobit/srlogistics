<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStateRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 176,
'name' => 'Allen'
],[
'state_id' => 176,
'name' => 'Catriel'
],[
'state_id' => 176,
'name' => 'Cervantes'
],[
'state_id' => 176,
'name' => 'Chichinales'
],[
'state_id' => 176,
'name' => 'Chimpay'
],[
'state_id' => 176,
'name' => 'Choele Choel'
],[
'state_id' => 176,
'name' => 'Cinco Saltos'
],[
'state_id' => 176,
'name' => 'Cipolletti'
],[
'state_id' => 176,
'name' => 'Comallo'
],[
'state_id' => 176,
'name' => 'Contraalmirante Cordero'
],[
'state_id' => 176,
'name' => 'Coronel Belisle'
],[
'state_id' => 176,
'name' => 'Darwin'
],[
'state_id' => 176,
'name' => 'Departamento de Avellaneda'
],[
'state_id' => 176,
'name' => 'Departamento de Veinticinco de Mayo'
],[
'state_id' => 176,
'name' => 'El Bolsón'
],[
'state_id' => 176,
'name' => 'El Cuy'
],[
'state_id' => 176,
'name' => 'Fray Luis Beltrán'
],[
'state_id' => 176,
'name' => 'General Conesa'
],[
'state_id' => 176,
'name' => 'General Enrique Godoy'
],[
'state_id' => 176,
'name' => 'General Fernández Oro'
],[
'state_id' => 176,
'name' => 'General Roca'
],[
'state_id' => 176,
'name' => 'Ingeniero Jacobacci'
],[
'state_id' => 176,
'name' => 'Ingeniero Luis A. Huergo'
],[
'state_id' => 176,
'name' => 'Lamarque'
],[
'state_id' => 176,
'name' => 'Los Menucos'
],[
'state_id' => 176,
'name' => 'Mainque'
],[
'state_id' => 176,
'name' => 'Maquinchao'
],[
'state_id' => 176,
'name' => 'Pilcaniyeu'
],[
'state_id' => 176,
'name' => 'Río Colorado'
],[
'state_id' => 176,
'name' => 'San Antonio Oeste'
],[
'state_id' => 176,
'name' => 'San Carlos de Bariloche'
],[
'state_id' => 176,
'name' => 'Sierra Colorada'
],[
'state_id' => 176,
'name' => 'Sierra Grande'
],[
'state_id' => 176,
'name' => 'Valcheta'
],[
'state_id' => 176,
'name' => 'Viedma'
],[
'state_id' => 176,
'name' => 'Villa Regina'
],[
'state_id' => 176,
'name' => 'Ñorquinco'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
