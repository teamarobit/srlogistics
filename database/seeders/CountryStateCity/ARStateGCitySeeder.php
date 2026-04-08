<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStateGCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 172,
'name' => 'Añatuya'
],[
'state_id' => 172,
'name' => 'Beltrán'
],[
'state_id' => 172,
'name' => 'Campo Gallo'
],[
'state_id' => 172,
'name' => 'Clodomira'
],[
'state_id' => 172,
'name' => 'Colonia Dora'
],[
'state_id' => 172,
'name' => 'Departamento de Aguirre'
],[
'state_id' => 172,
'name' => 'Departamento de Banda'
],[
'state_id' => 172,
'name' => 'Departamento de Choya'
],[
'state_id' => 172,
'name' => 'Departamento de Guasayán'
],[
'state_id' => 172,
'name' => 'Departamento de Loreto'
],[
'state_id' => 172,
'name' => 'Departamento de Moreno'
],[
'state_id' => 172,
'name' => 'Departamento de Robles'
],[
'state_id' => 172,
'name' => 'Departamento de Río Hondo'
],[
'state_id' => 172,
'name' => 'Departamento de San Martín'
],[
'state_id' => 172,
'name' => 'Departamento de Sarmiento'
],[
'state_id' => 172,
'name' => 'El Hoyo'
],[
'state_id' => 172,
'name' => 'La Banda'
],[
'state_id' => 172,
'name' => 'Los Juríes'
],[
'state_id' => 172,
'name' => 'Los Telares'
],[
'state_id' => 172,
'name' => 'Pampa de los Guanacos'
],[
'state_id' => 172,
'name' => 'Quimilí'
],[
'state_id' => 172,
'name' => 'San Pedro'
],[
'state_id' => 172,
'name' => 'Santiago del Estero'
],[
'state_id' => 172,
'name' => 'Sumampa'
],[
'state_id' => 172,
'name' => 'Suncho Corral'
],[
'state_id' => 172,
'name' => 'Termas de Río Hondo'
],[
'state_id' => 172,
'name' => 'Tintina'
],[
'state_id' => 172,
'name' => 'Villa Atamisqui'
],[
'state_id' => 172,
'name' => 'Villa General Mitre'
],[
'state_id' => 172,
'name' => 'Villa Ojo de Agua'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
