<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HNStateFMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1604,
'name' => 'Agalteca'
],[
'state_id' => 1604,
'name' => 'Alubarén'
],[
'state_id' => 1604,
'name' => 'Cedros'
],[
'state_id' => 1604,
'name' => 'Cerro Grande'
],[
'state_id' => 1604,
'name' => 'Cofradía'
],[
'state_id' => 1604,
'name' => 'Curarén'
],[
'state_id' => 1604,
'name' => 'Distrito Central'
],[
'state_id' => 1604,
'name' => 'El Chimbo'
],[
'state_id' => 1604,
'name' => 'El Escanito'
],[
'state_id' => 1604,
'name' => 'El Escaño de Tepale'
],[
'state_id' => 1604,
'name' => 'El Guante'
],[
'state_id' => 1604,
'name' => 'El Guantillo'
],[
'state_id' => 1604,
'name' => 'El Guapinol'
],[
'state_id' => 1604,
'name' => 'El Lolo'
],[
'state_id' => 1604,
'name' => 'El Pedernal'
],[
'state_id' => 1604,
'name' => 'El Porvenir'
],[
'state_id' => 1604,
'name' => 'El Suyatal'
],[
'state_id' => 1604,
'name' => 'El Tablón'
],[
'state_id' => 1604,
'name' => 'El Terrero'
],[
'state_id' => 1604,
'name' => 'Guaimaca'
],[
'state_id' => 1604,
'name' => 'La Ermita'
],[
'state_id' => 1604,
'name' => 'La Libertad'
],[
'state_id' => 1604,
'name' => 'La Venta'
],[
'state_id' => 1604,
'name' => 'Lepaterique'
],[
'state_id' => 1604,
'name' => 'Maraita'
],[
'state_id' => 1604,
'name' => 'Marale'
],[
'state_id' => 1604,
'name' => 'Mata de Plátano'
],[
'state_id' => 1604,
'name' => 'Mateo'
],[
'state_id' => 1604,
'name' => 'Nueva Armenia'
],[
'state_id' => 1604,
'name' => 'Ojojona'
],[
'state_id' => 1604,
'name' => 'Orica'
],[
'state_id' => 1604,
'name' => 'Quebradas'
],[
'state_id' => 1604,
'name' => 'Reitoca'
],[
'state_id' => 1604,
'name' => 'Río Abajo'
],[
'state_id' => 1604,
'name' => 'Sabanagrande'
],[
'state_id' => 1604,
'name' => 'San Antonio de Oriente'
],[
'state_id' => 1604,
'name' => 'San Buenaventura'
],[
'state_id' => 1604,
'name' => 'San Ignacio'
],[
'state_id' => 1604,
'name' => 'San Juan de Flores'
],[
'state_id' => 1604,
'name' => 'San Miguelito'
],[
'state_id' => 1604,
'name' => 'Santa Ana'
],[
'state_id' => 1604,
'name' => 'Santa Lucía'
],[
'state_id' => 1604,
'name' => 'Talanga'
],[
'state_id' => 1604,
'name' => 'Tatumbla'
],[
'state_id' => 1604,
'name' => 'Tegucigalpa'
],[
'state_id' => 1604,
'name' => 'Támara'
],[
'state_id' => 1604,
'name' => 'Valle de Ángeles'
],[
'state_id' => 1604,
'name' => 'Vallecillo'
],[
'state_id' => 1604,
'name' => 'Villa Nueva'
],[
'state_id' => 1604,
'name' => 'Villa de San Francisco'
],[
'state_id' => 1604,
'name' => 'Yaguacire'
],[
'state_id' => 1604,
'name' => 'Zambrano'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
