<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class VEStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 239,
'name' => 'Cojedes',
'iso2' => 'H'
],[
'country_id' => 239,
'name' => 'Falcón',
'iso2' => 'I'
],[
'country_id' => 239,
'name' => 'Portuguesa',
'iso2' => 'P'
],[
'country_id' => 239,
'name' => 'Miranda',
'iso2' => 'M'
],[
'country_id' => 239,
'name' => 'Lara',
'iso2' => 'K'
],[
'country_id' => 239,
'name' => 'Bolívar',
'iso2' => 'F'
],[
'country_id' => 239,
'name' => 'Carabobo',
'iso2' => 'G'
],[
'country_id' => 239,
'name' => 'Yaracuy',
'iso2' => 'U'
],[
'country_id' => 239,
'name' => 'Zulia',
'iso2' => 'V'
],[
'country_id' => 239,
'name' => 'Trujillo',
'iso2' => 'T'
],[
'country_id' => 239,
'name' => 'Amazonas',
'iso2' => 'Z'
],[
'country_id' => 239,
'name' => 'Guárico',
'iso2' => 'J'
],[
'country_id' => 239,
'name' => 'Federal Dependencies of Venezuela',
'iso2' => 'W'
],[
'country_id' => 239,
'name' => 'Aragua',
'iso2' => 'D'
],[
'country_id' => 239,
'name' => 'Táchira',
'iso2' => 'S'
],[
'country_id' => 239,
'name' => 'Barinas',
'iso2' => 'E'
],[
'country_id' => 239,
'name' => 'Anzoátegui',
'iso2' => 'B'
],[
'country_id' => 239,
'name' => 'Delta Amacuro',
'iso2' => 'Y'
],[
'country_id' => 239,
'name' => 'Nueva Esparta',
'iso2' => 'O'
],[
'country_id' => 239,
'name' => 'Mérida',
'iso2' => 'L'
],[
'country_id' => 239,
'name' => 'Monagas',
'iso2' => 'N'
],[
'country_id' => 239,
'name' => 'La Guaira',
'iso2' => 'X'
],[
'country_id' => 239,
'name' => 'Sucre',
'iso2' => 'R'
],[
'country_id' => 239,
'name' => 'Distrito Capital',
'iso2' => 'A'
],[
'country_id' => 239,
'name' => 'Apure',
'iso2' => 'C'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
