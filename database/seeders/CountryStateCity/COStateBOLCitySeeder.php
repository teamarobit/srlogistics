<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateBOLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 838,
'name' => 'Achí'
],[
'state_id' => 838,
'name' => 'Altos del Rosario'
],[
'state_id' => 838,
'name' => 'Arenal'
],[
'state_id' => 838,
'name' => 'Arjona'
],[
'state_id' => 838,
'name' => 'Arroyohondo'
],[
'state_id' => 838,
'name' => 'Barranco de Loba'
],[
'state_id' => 838,
'name' => 'Calamar'
],[
'state_id' => 838,
'name' => 'Cantagallo'
],[
'state_id' => 838,
'name' => 'Cartagena de Indias'
],[
'state_id' => 838,
'name' => 'Cicuco'
],[
'state_id' => 838,
'name' => 'Clemencia'
],[
'state_id' => 838,
'name' => 'Córdoba'
],[
'state_id' => 838,
'name' => 'El Carmen de Bolívar'
],[
'state_id' => 838,
'name' => 'El Guamo'
],[
'state_id' => 838,
'name' => 'El Peñón'
],[
'state_id' => 838,
'name' => 'Hatillo de Loba'
],[
'state_id' => 838,
'name' => 'Magangué'
],[
'state_id' => 838,
'name' => 'Mahates'
],[
'state_id' => 838,
'name' => 'Margarita'
],[
'state_id' => 838,
'name' => 'María la Baja'
],[
'state_id' => 838,
'name' => 'Mompós'
],[
'state_id' => 838,
'name' => 'Montecristo'
],[
'state_id' => 838,
'name' => 'Morales'
],[
'state_id' => 838,
'name' => 'Norosí'
],[
'state_id' => 838,
'name' => 'Pinillos'
],[
'state_id' => 838,
'name' => 'Regidor'
],[
'state_id' => 838,
'name' => 'Río Viejo'
],[
'state_id' => 838,
'name' => 'San Cristóbal'
],[
'state_id' => 838,
'name' => 'San Estanislao'
],[
'state_id' => 838,
'name' => 'San Fernando'
],[
'state_id' => 838,
'name' => 'San Jacinto'
],[
'state_id' => 838,
'name' => 'San Jacinto del Cauca'
],[
'state_id' => 838,
'name' => 'San Juan Nepomuceno'
],[
'state_id' => 838,
'name' => 'San Martín de Loba'
],[
'state_id' => 838,
'name' => 'San Pablo'
],[
'state_id' => 838,
'name' => 'Santa Catalina'
],[
'state_id' => 838,
'name' => 'Santa Rosa'
],[
'state_id' => 838,
'name' => 'Santa Rosa del Sur'
],[
'state_id' => 838,
'name' => 'Simití'
],[
'state_id' => 838,
'name' => 'Soplaviento'
],[
'state_id' => 838,
'name' => 'Talaigua Nuevo'
],[
'state_id' => 838,
'name' => 'Tiquisio'
],[
'state_id' => 838,
'name' => 'Turbaco'
],[
'state_id' => 838,
'name' => 'Turbaná'
],[
'state_id' => 838,
'name' => 'Villanueva'
],[
'state_id' => 838,
'name' => 'Zambrano'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
