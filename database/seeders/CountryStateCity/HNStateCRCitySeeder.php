<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HNStateCRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1598,
'name' => 'Agua Azul'
],[
'state_id' => 1598,
'name' => 'Agua Azul Rancho'
],[
'state_id' => 1598,
'name' => 'Armenta'
],[
'state_id' => 1598,
'name' => 'Baja Mar'
],[
'state_id' => 1598,
'name' => 'Baracoa'
],[
'state_id' => 1598,
'name' => 'Bejuco'
],[
'state_id' => 1598,
'name' => 'Casa Quemada'
],[
'state_id' => 1598,
'name' => 'Cañaveral'
],[
'state_id' => 1598,
'name' => 'Chivana'
],[
'state_id' => 1598,
'name' => 'Choloma'
],[
'state_id' => 1598,
'name' => 'Chotepe'
],[
'state_id' => 1598,
'name' => 'Cofradía'
],[
'state_id' => 1598,
'name' => 'Cuyamel'
],[
'state_id' => 1598,
'name' => 'El Llano'
],[
'state_id' => 1598,
'name' => 'El Marañón'
],[
'state_id' => 1598,
'name' => 'El Milagro'
],[
'state_id' => 1598,
'name' => 'El Olivar'
],[
'state_id' => 1598,
'name' => 'El Perico'
],[
'state_id' => 1598,
'name' => 'El Plan'
],[
'state_id' => 1598,
'name' => 'El Porvenir'
],[
'state_id' => 1598,
'name' => 'El Rancho'
],[
'state_id' => 1598,
'name' => 'El Tigre'
],[
'state_id' => 1598,
'name' => 'El Zapotal del Norte'
],[
'state_id' => 1598,
'name' => 'La Guama'
],[
'state_id' => 1598,
'name' => 'La Huesa'
],[
'state_id' => 1598,
'name' => 'La Jutosa'
],[
'state_id' => 1598,
'name' => 'La Lima'
],[
'state_id' => 1598,
'name' => 'La Sabana'
],[
'state_id' => 1598,
'name' => 'Los Caminos'
],[
'state_id' => 1598,
'name' => 'Los Naranjos'
],[
'state_id' => 1598,
'name' => 'Monterrey'
],[
'state_id' => 1598,
'name' => 'Nuevo Chamelecón'
],[
'state_id' => 1598,
'name' => 'Omoa'
],[
'state_id' => 1598,
'name' => 'Oropéndolas'
],[
'state_id' => 1598,
'name' => 'Peña Blanca'
],[
'state_id' => 1598,
'name' => 'Pimienta'
],[
'state_id' => 1598,
'name' => 'Pimienta Vieja'
],[
'state_id' => 1598,
'name' => 'Potrerillos'
],[
'state_id' => 1598,
'name' => 'Pueblo Nuevo'
],[
'state_id' => 1598,
'name' => 'Puerto Alto'
],[
'state_id' => 1598,
'name' => 'Puerto Cortez'
],[
'state_id' => 1598,
'name' => 'Puerto Cortés'
],[
'state_id' => 1598,
'name' => 'Quebrada Seca'
],[
'state_id' => 1598,
'name' => 'Río Blanquito'
],[
'state_id' => 1598,
'name' => 'Río Chiquito'
],[
'state_id' => 1598,
'name' => 'Río Lindo'
],[
'state_id' => 1598,
'name' => 'San Antonio de Cortés'
],[
'state_id' => 1598,
'name' => 'San Buenaventura'
],[
'state_id' => 1598,
'name' => 'San Francisco de Yojoa'
],[
'state_id' => 1598,
'name' => 'San José del Boquerón'
],[
'state_id' => 1598,
'name' => 'San Manuel'
],[
'state_id' => 1598,
'name' => 'San Pedro Sula'
],[
'state_id' => 1598,
'name' => 'Santa Cruz de Yojoa'
],[
'state_id' => 1598,
'name' => 'Santa Elena'
],[
'state_id' => 1598,
'name' => 'Travesía'
],[
'state_id' => 1598,
'name' => 'Villanueva'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
