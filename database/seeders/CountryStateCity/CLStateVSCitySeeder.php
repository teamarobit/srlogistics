<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CLStateVSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 776,
'name' => 'Cartagena'
],[
'state_id' => 776,
'name' => 'La Ligua'
],[
'state_id' => 776,
'name' => 'Limache'
],[
'state_id' => 776,
'name' => 'Llaillay'
],[
'state_id' => 776,
'name' => 'Los Andes'
],[
'state_id' => 776,
'name' => 'Isla de Pascua'
],[
'state_id' => 776,
'name' => 'Quillota'
],[
'state_id' => 776,
'name' => 'Quilpué'
],[
'state_id' => 776,
'name' => 'San Antonio'
],[
'state_id' => 776,
'name' => 'San Felipe'
],[
'state_id' => 776,
'name' => 'Valparaíso'
],[
'state_id' => 776,
'name' => 'Villa Alemana'
],[
'state_id' => 776,
'name' => 'Viña del Mar'
],[
'state_id' => 776,
'name' => 'Algarrobo'
],[
'state_id' => 776,
'name' => 'Cabildo'
],[
'state_id' => 776,
'name' => 'Calle Larga'
],[
'state_id' => 776,
'name' => 'Casablanca'
],[
'state_id' => 776,
'name' => 'Catemu'
],[
'state_id' => 776,
'name' => 'Concón'
],[
'state_id' => 776,
'name' => 'El Quisco'
],[
'state_id' => 776,
'name' => 'El Tabo'
],[
'state_id' => 776,
'name' => 'Hijuelas'
],[
'state_id' => 776,
'name' => 'Juan Fernández'
],[
'state_id' => 776,
'name' => 'Santo Domingo'
],[
'state_id' => 776,
'name' => 'La Calera'
],[
'state_id' => 776,
'name' => 'La Cruz'
],[
'state_id' => 776,
'name' => 'Nogales'
],[
'state_id' => 776,
'name' => 'Olmué'
],[
'state_id' => 776,
'name' => 'Panquehue'
],[
'state_id' => 776,
'name' => 'Papudo'
],[
'state_id' => 776,
'name' => 'Petorca'
],[
'state_id' => 776,
'name' => 'Puchuncaví'
],[
'state_id' => 776,
'name' => 'Putaendo'
],[
'state_id' => 776,
'name' => 'Quintero'
],[
'state_id' => 776,
'name' => 'Rinconada'
],[
'state_id' => 776,
'name' => 'San Esteban'
],[
'state_id' => 776,
'name' => 'Santa María'
],[
'state_id' => 776,
'name' => 'Zapallar'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
