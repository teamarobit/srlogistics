<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStateUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 188,
'name' => 'Alto Río Senguer'
],[
'state_id' => 188,
'name' => 'Camarones'
],[
'state_id' => 188,
'name' => 'Comodoro Rivadavia'
],[
'state_id' => 188,
'name' => 'Departamento de Biedma'
],[
'state_id' => 188,
'name' => 'Departamento de Cushamen'
],[
'state_id' => 188,
'name' => 'Departamento de Escalante'
],[
'state_id' => 188,
'name' => 'Departamento de Florentino Ameghino'
],[
'state_id' => 188,
'name' => 'Departamento de Futaleufú'
],[
'state_id' => 188,
'name' => 'Departamento de Gaimán'
],[
'state_id' => 188,
'name' => 'Departamento de Gastre'
],[
'state_id' => 188,
'name' => 'Departamento de Languiñeo'
],[
'state_id' => 188,
'name' => 'Departamento de Mártires'
],[
'state_id' => 188,
'name' => 'Departamento de Paso de Indios'
],[
'state_id' => 188,
'name' => 'Departamento de Rawson'
],[
'state_id' => 188,
'name' => 'Departamento de Río Senguerr'
],[
'state_id' => 188,
'name' => 'Departamento de Sarmiento'
],[
'state_id' => 188,
'name' => 'Departamento de Tehuelches'
],[
'state_id' => 188,
'name' => 'Departamento de Telsen'
],[
'state_id' => 188,
'name' => 'Dolavón'
],[
'state_id' => 188,
'name' => 'El Maitén'
],[
'state_id' => 188,
'name' => 'Esquel'
],[
'state_id' => 188,
'name' => 'Gaimán'
],[
'state_id' => 188,
'name' => 'Gastre'
],[
'state_id' => 188,
'name' => 'Gobernador Costa'
],[
'state_id' => 188,
'name' => 'Hoyo de Epuyén'
],[
'state_id' => 188,
'name' => 'José de San Martín'
],[
'state_id' => 188,
'name' => 'Lago Puelo'
],[
'state_id' => 188,
'name' => 'Las Plumas'
],[
'state_id' => 188,
'name' => 'Puerto Madryn'
],[
'state_id' => 188,
'name' => 'Rada Tilly'
],[
'state_id' => 188,
'name' => 'Rawson'
],[
'state_id' => 188,
'name' => 'Río Mayo'
],[
'state_id' => 188,
'name' => 'Río Pico'
],[
'state_id' => 188,
'name' => 'Sarmiento'
],[
'state_id' => 188,
'name' => 'Tecka'
],[
'state_id' => 188,
'name' => 'Trelew'
],[
'state_id' => 188,
'name' => 'Trevelin'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
