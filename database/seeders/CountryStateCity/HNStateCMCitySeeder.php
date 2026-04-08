<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HNStateCMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1594,
'name' => 'Aguas del Padre'
],[
'state_id' => 1594,
'name' => 'Ajuterique'
],[
'state_id' => 1594,
'name' => 'Cerro Blanco'
],[
'state_id' => 1594,
'name' => 'Comayagua'
],[
'state_id' => 1594,
'name' => 'Concepción de Guasistagua'
],[
'state_id' => 1594,
'name' => 'El Agua Dulcita'
],[
'state_id' => 1594,
'name' => 'El Porvenir'
],[
'state_id' => 1594,
'name' => 'El Rancho'
],[
'state_id' => 1594,
'name' => 'El Rincón'
],[
'state_id' => 1594,
'name' => 'El Rosario'
],[
'state_id' => 1594,
'name' => 'El Sauce'
],[
'state_id' => 1594,
'name' => 'El Socorro'
],[
'state_id' => 1594,
'name' => 'Esquías'
],[
'state_id' => 1594,
'name' => 'Flores'
],[
'state_id' => 1594,
'name' => 'Humuya'
],[
'state_id' => 1594,
'name' => 'Jamalteca'
],[
'state_id' => 1594,
'name' => 'La Libertad'
],[
'state_id' => 1594,
'name' => 'La Trinidad'
],[
'state_id' => 1594,
'name' => 'Lamaní'
],[
'state_id' => 1594,
'name' => 'Las Lajas'
],[
'state_id' => 1594,
'name' => 'Lejamaní'
],[
'state_id' => 1594,
'name' => 'Meámbar'
],[
'state_id' => 1594,
'name' => 'Minas de Oro'
],[
'state_id' => 1594,
'name' => 'Ojos de Agua'
],[
'state_id' => 1594,
'name' => 'Potrerillos'
],[
'state_id' => 1594,
'name' => 'Río Bonito'
],[
'state_id' => 1594,
'name' => 'San Antonio de la Cuesta'
],[
'state_id' => 1594,
'name' => 'San Jerónimo'
],[
'state_id' => 1594,
'name' => 'San José de Comayagua'
],[
'state_id' => 1594,
'name' => 'San José del Potrero'
],[
'state_id' => 1594,
'name' => 'San Luis'
],[
'state_id' => 1594,
'name' => 'San Sebastián'
],[
'state_id' => 1594,
'name' => 'Siguatepeque'
],[
'state_id' => 1594,
'name' => 'Taulabé'
],[
'state_id' => 1594,
'name' => 'Valle de Ángeles'
],[
'state_id' => 1594,
'name' => 'Villa de San Antonio'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
