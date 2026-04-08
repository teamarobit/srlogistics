<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStateHCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 177,
'name' => 'Aviá Terai'
],[
'state_id' => 177,
'name' => 'Barranqueras'
],[
'state_id' => 177,
'name' => 'Basail'
],[
'state_id' => 177,
'name' => 'Campo Largo'
],[
'state_id' => 177,
'name' => 'Capitán Solari'
],[
'state_id' => 177,
'name' => 'Castelli'
],[
'state_id' => 177,
'name' => 'Charadai'
],[
'state_id' => 177,
'name' => 'Charata'
],[
'state_id' => 177,
'name' => 'Chorotis'
],[
'state_id' => 177,
'name' => 'Ciervo Petiso'
],[
'state_id' => 177,
'name' => 'Colonia Benítez'
],[
'state_id' => 177,
'name' => 'Colonia Elisa'
],[
'state_id' => 177,
'name' => 'Colonias Unidas'
],[
'state_id' => 177,
'name' => 'Concepción del Bermejo'
],[
'state_id' => 177,
'name' => 'Coronel Du Graty'
],[
'state_id' => 177,
'name' => 'Corzuela'
],[
'state_id' => 177,
'name' => 'Coté-Lai'
],[
'state_id' => 177,
'name' => 'Departamento de Almirante Brown'
],[
'state_id' => 177,
'name' => 'Departamento de Bermejo'
],[
'state_id' => 177,
'name' => 'Departamento de Comandante Fernández'
],[
'state_id' => 177,
'name' => 'Departamento de Doce de Octubre'
],[
'state_id' => 177,
'name' => 'Departamento de Dos de Abril'
],[
'state_id' => 177,
'name' => 'Departamento de General Donovan'
],[
'state_id' => 177,
'name' => 'Departamento de General Güemes'
],[
'state_id' => 177,
'name' => 'Departamento de Independencia'
],[
'state_id' => 177,
'name' => 'Departamento de Libertad'
],[
'state_id' => 177,
'name' => 'Departamento de Maipú'
],[
'state_id' => 177,
'name' => 'Departamento de Nueve de Julio'
],[
'state_id' => 177,
'name' => 'Departamento de O’Higgins'
],[
'state_id' => 177,
'name' => 'Departamento de Presidencia de la Plaza'
],[
'state_id' => 177,
'name' => 'Departamento de Quitilipi'
],[
'state_id' => 177,
'name' => 'Departamento de San Fernando'
],[
'state_id' => 177,
'name' => 'Departamento de San Lorenzo'
],[
'state_id' => 177,
'name' => 'Departamento de Sargento Cabral'
],[
'state_id' => 177,
'name' => 'Departamento de Tapenagá'
],[
'state_id' => 177,
'name' => 'Fontana'
],[
'state_id' => 177,
'name' => 'Gancedo'
],[
'state_id' => 177,
'name' => 'General José de San Martín'
],[
'state_id' => 177,
'name' => 'General Pinedo'
],[
'state_id' => 177,
'name' => 'General Vedia'
],[
'state_id' => 177,
'name' => 'Hermoso Campo'
],[
'state_id' => 177,
'name' => 'La Clotilde'
],[
'state_id' => 177,
'name' => 'La Eduvigis'
],[
'state_id' => 177,
'name' => 'La Escondida'
],[
'state_id' => 177,
'name' => 'La Leonesa'
],[
'state_id' => 177,
'name' => 'La Tigra'
],[
'state_id' => 177,
'name' => 'La Verde'
],[
'state_id' => 177,
'name' => 'Laguna Limpia'
],[
'state_id' => 177,
'name' => 'Lapachito'
],[
'state_id' => 177,
'name' => 'Las Breñas'
],[
'state_id' => 177,
'name' => 'Las Garcitas'
],[
'state_id' => 177,
'name' => 'Los Frentones'
],[
'state_id' => 177,
'name' => 'Machagai'
],[
'state_id' => 177,
'name' => 'Makallé'
],[
'state_id' => 177,
'name' => 'Margarita Belén'
],[
'state_id' => 177,
'name' => 'Napenay'
],[
'state_id' => 177,
'name' => 'Pampa Almirón'
],[
'state_id' => 177,
'name' => 'Pampa del Indio'
],[
'state_id' => 177,
'name' => 'Pampa del Infierno'
],[
'state_id' => 177,
'name' => 'Presidencia Roca'
],[
'state_id' => 177,
'name' => 'Presidencia Roque Sáenz Peña'
],[
'state_id' => 177,
'name' => 'Presidencia de la Plaza'
],[
'state_id' => 177,
'name' => 'Puerto Bermejo'
],[
'state_id' => 177,
'name' => 'Puerto Tirol'
],[
'state_id' => 177,
'name' => 'Puerto Vilelas'
],[
'state_id' => 177,
'name' => 'Quitilipi'
],[
'state_id' => 177,
'name' => 'Resistencia'
],[
'state_id' => 177,
'name' => 'Samuhú'
],[
'state_id' => 177,
'name' => 'San Bernardo'
],[
'state_id' => 177,
'name' => 'Santa Sylvina'
],[
'state_id' => 177,
'name' => 'Taco Pozo'
],[
'state_id' => 177,
'name' => 'Tres Isletas'
],[
'state_id' => 177,
'name' => 'Villa Berthet'
],[
'state_id' => 177,
'name' => 'Villa Ángela'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
