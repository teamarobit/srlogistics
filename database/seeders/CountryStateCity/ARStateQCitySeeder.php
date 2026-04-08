<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStateQCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 185,
'name' => 'Aluminé'
],[
'state_id' => 185,
'name' => 'Andacollo'
],[
'state_id' => 185,
'name' => 'Añelo'
],[
'state_id' => 185,
'name' => 'Barrancas'
],[
'state_id' => 185,
'name' => 'Buta Ranquil'
],[
'state_id' => 185,
'name' => 'Centenario'
],[
'state_id' => 185,
'name' => 'Chos Malal'
],[
'state_id' => 185,
'name' => 'Cutral-Có'
],[
'state_id' => 185,
'name' => 'Departamento de Aluminé'
],[
'state_id' => 185,
'name' => 'Departamento de Añelo'
],[
'state_id' => 185,
'name' => 'Departamento de Catán-Lil'
],[
'state_id' => 185,
'name' => 'Departamento de Chos-Malal'
],[
'state_id' => 185,
'name' => 'Departamento de Collón-Curá'
],[
'state_id' => 185,
'name' => 'Departamento de Confluencia'
],[
'state_id' => 185,
'name' => 'Departamento de Lácar'
],[
'state_id' => 185,
'name' => 'Departamento de Minas'
],[
'state_id' => 185,
'name' => 'Departamento de Zapala'
],[
'state_id' => 185,
'name' => 'El Huecú'
],[
'state_id' => 185,
'name' => 'Junín de los Andes'
],[
'state_id' => 185,
'name' => 'Las Coloradas'
],[
'state_id' => 185,
'name' => 'Las Lajas'
],[
'state_id' => 185,
'name' => 'Las Ovejas'
],[
'state_id' => 185,
'name' => 'Loncopué'
],[
'state_id' => 185,
'name' => 'Mariano Moreno'
],[
'state_id' => 185,
'name' => 'Neuquén'
],[
'state_id' => 185,
'name' => 'Picún Leufú'
],[
'state_id' => 185,
'name' => 'Piedra del Águila'
],[
'state_id' => 185,
'name' => 'Plaza Huincul'
],[
'state_id' => 185,
'name' => 'Plottier'
],[
'state_id' => 185,
'name' => 'San Martín de los Andes'
],[
'state_id' => 185,
'name' => 'Senillosa'
],[
'state_id' => 185,
'name' => 'Villa La Angostura'
],[
'state_id' => 185,
'name' => 'Vista Alegre'
],[
'state_id' => 185,
'name' => 'Zapala'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
