<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class ARStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 11,
'name' => 'San Juan',
'iso2' => 'J'
],[
'country_id' => 11,
'name' => 'Santiago del Estero',
'iso2' => 'G'
],[
'country_id' => 11,
'name' => 'San Luis',
'iso2' => 'D'
],[
'country_id' => 11,
'name' => 'Tucumán',
'iso2' => 'T'
],[
'country_id' => 11,
'name' => 'Corrientes',
'iso2' => 'W'
],[
'country_id' => 11,
'name' => 'Río Negro',
'iso2' => 'R'
],[
'country_id' => 11,
'name' => 'Chaco',
'iso2' => 'H'
],[
'country_id' => 11,
'name' => 'Santa Fe',
'iso2' => 'S'
],[
'country_id' => 11,
'name' => 'Córdoba',
'iso2' => 'X'
],[
'country_id' => 11,
'name' => 'Salta',
'iso2' => 'A'
],[
'country_id' => 11,
'name' => 'Misiones',
'iso2' => 'N'
],[
'country_id' => 11,
'name' => 'Jujuy',
'iso2' => 'Y'
],[
'country_id' => 11,
'name' => 'Mendoza',
'iso2' => 'M'
],[
'country_id' => 11,
'name' => 'Catamarca',
'iso2' => 'K'
],[
'country_id' => 11,
'name' => 'Neuquén',
'iso2' => 'Q'
],[
'country_id' => 11,
'name' => 'Santa Cruz',
'iso2' => 'Z'
],[
'country_id' => 11,
'name' => 'Tierra del Fuego',
'iso2' => 'V'
],[
'country_id' => 11,
'name' => 'Chubut',
'iso2' => 'U'
],[
'country_id' => 11,
'name' => 'Formosa',
'iso2' => 'P'
],[
'country_id' => 11,
'name' => 'La Rioja',
'iso2' => 'F'
],[
'country_id' => 11,
'name' => 'Entre Ríos',
'iso2' => 'E'
],[
'country_id' => 11,
'name' => 'La Pampa',
'iso2' => 'L'
],[
'country_id' => 11,
'name' => 'Buenos Aires',
'iso2' => 'B'
],[
'country_id' => 11,
'name' => 'Ciudad Autónoma de Buenos Aires',
'iso2' => 'C'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
