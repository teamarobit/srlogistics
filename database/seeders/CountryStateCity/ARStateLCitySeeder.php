<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStateLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 192,
'name' => 'Alpachiri'
],[
'state_id' => 192,
'name' => 'Alta Italia'
],[
'state_id' => 192,
'name' => 'Anguil'
],[
'state_id' => 192,
'name' => 'Arata'
],[
'state_id' => 192,
'name' => 'Bernardo Larroudé'
],[
'state_id' => 192,
'name' => 'Bernasconi'
],[
'state_id' => 192,
'name' => 'Caleufú'
],[
'state_id' => 192,
'name' => 'Catriló'
],[
'state_id' => 192,
'name' => 'Colonia Barón'
],[
'state_id' => 192,
'name' => 'Departamento de Caleu-Caleu'
],[
'state_id' => 192,
'name' => 'Departamento de Toay'
],[
'state_id' => 192,
'name' => 'Doblas'
],[
'state_id' => 192,
'name' => 'Eduardo Castex'
],[
'state_id' => 192,
'name' => 'Embajador Martini'
],[
'state_id' => 192,
'name' => 'General Acha'
],[
'state_id' => 192,
'name' => 'General Manuel J. Campos'
],[
'state_id' => 192,
'name' => 'General Pico'
],[
'state_id' => 192,
'name' => 'General San Martín'
],[
'state_id' => 192,
'name' => 'Guatraché'
],[
'state_id' => 192,
'name' => 'Ingeniero Luiggi'
],[
'state_id' => 192,
'name' => 'Intendente Alvear'
],[
'state_id' => 192,
'name' => 'Jacinto Arauz'
],[
'state_id' => 192,
'name' => 'La Adela'
],[
'state_id' => 192,
'name' => 'La Maruja'
],[
'state_id' => 192,
'name' => 'Lonquimay'
],[
'state_id' => 192,
'name' => 'Macachín'
],[
'state_id' => 192,
'name' => 'Miguel Riglos'
],[
'state_id' => 192,
'name' => 'Parera'
],[
'state_id' => 192,
'name' => 'Quemú Quemú'
],[
'state_id' => 192,
'name' => 'Rancul'
],[
'state_id' => 192,
'name' => 'Realicó'
],[
'state_id' => 192,
'name' => 'Santa Isabel'
],[
'state_id' => 192,
'name' => 'Santa Rosa'
],[
'state_id' => 192,
'name' => 'Telén'
],[
'state_id' => 192,
'name' => 'Trenel'
],[
'state_id' => 192,
'name' => 'Uriburu'
],[
'state_id' => 192,
'name' => 'Veinticinco de Mayo'
],[
'state_id' => 192,
'name' => 'Victorica'
],[
'state_id' => 192,
'name' => 'Winifreda'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
