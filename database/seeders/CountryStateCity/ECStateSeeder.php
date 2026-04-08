<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class ECStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 64,
'name' => 'Galápagos',
'iso2' => 'W'
],[
'country_id' => 64,
'name' => 'Sucumbíos',
'iso2' => 'U'
],[
'country_id' => 64,
'name' => 'Pastaza',
'iso2' => 'Y'
],[
'country_id' => 64,
'name' => 'Tungurahua',
'iso2' => 'T'
],[
'country_id' => 64,
'name' => 'Zamora Chinchipe',
'iso2' => 'Z'
],[
'country_id' => 64,
'name' => 'Los Ríos',
'iso2' => 'R'
],[
'country_id' => 64,
'name' => 'Imbabura',
'iso2' => 'I'
],[
'country_id' => 64,
'name' => 'Santa Elena',
'iso2' => 'SE'
],[
'country_id' => 64,
'name' => 'Manabí',
'iso2' => 'M'
],[
'country_id' => 64,
'name' => 'Guayas',
'iso2' => 'G'
],[
'country_id' => 64,
'name' => 'Carchi',
'iso2' => 'C'
],[
'country_id' => 64,
'name' => 'Napo',
'iso2' => 'N'
],[
'country_id' => 64,
'name' => 'Cañar',
'iso2' => 'F'
],[
'country_id' => 64,
'name' => 'Morona-Santiago',
'iso2' => 'S'
],[
'country_id' => 64,
'name' => 'Santo Domingo de los Tsáchilas',
'iso2' => 'SD'
],[
'country_id' => 64,
'name' => 'Bolívar',
'iso2' => 'B'
],[
'country_id' => 64,
'name' => 'Cotopaxi',
'iso2' => 'X'
],[
'country_id' => 64,
'name' => 'Esmeraldas',
'iso2' => 'E'
],[
'country_id' => 64,
'name' => 'Azuay',
'iso2' => 'A'
],[
'country_id' => 64,
'name' => 'El Oro',
'iso2' => 'O'
],[
'country_id' => 64,
'name' => 'Chimborazo',
'iso2' => 'H'
],[
'country_id' => 64,
'name' => 'Orellana',
'iso2' => 'D'
],[
'country_id' => 64,
'name' => 'Pichincha',
'iso2' => 'P'
],[
'country_id' => 64,
'name' => 'Loja',
'iso2' => 'L'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
