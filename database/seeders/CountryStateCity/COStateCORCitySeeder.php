<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateCORCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 843,
'name' => 'Ayapel'
],[
'state_id' => 843,
'name' => 'Buenavista'
],[
'state_id' => 843,
'name' => 'Canalete'
],[
'state_id' => 843,
'name' => 'Cereté'
],[
'state_id' => 843,
'name' => 'Chimá'
],[
'state_id' => 843,
'name' => 'Chinú'
],[
'state_id' => 843,
'name' => 'Ciénaga de Oro'
],[
'state_id' => 843,
'name' => 'Cotorra'
],[
'state_id' => 843,
'name' => 'La Apartada'
],[
'state_id' => 843,
'name' => 'Lorica'
],[
'state_id' => 843,
'name' => 'Los Córdobas'
],[
'state_id' => 843,
'name' => 'Momil'
],[
'state_id' => 843,
'name' => 'Montelíbano'
],[
'state_id' => 843,
'name' => 'Montería'
],[
'state_id' => 843,
'name' => 'Moñitos'
],[
'state_id' => 843,
'name' => 'Planeta Rica'
],[
'state_id' => 843,
'name' => 'Pueblo Nuevo'
],[
'state_id' => 843,
'name' => 'Puerto Escondido'
],[
'state_id' => 843,
'name' => 'Puerto Libertador'
],[
'state_id' => 843,
'name' => 'Purísima'
],[
'state_id' => 843,
'name' => 'Sahagún'
],[
'state_id' => 843,
'name' => 'San Andrés de Sotavento'
],[
'state_id' => 843,
'name' => 'San Antero'
],[
'state_id' => 843,
'name' => 'San Bernardo del Viento'
],[
'state_id' => 843,
'name' => 'San Carlos'
],[
'state_id' => 843,
'name' => 'San Pelayo'
],[
'state_id' => 843,
'name' => 'Tierralta'
],[
'state_id' => 843,
'name' => 'Valencia'
],[
'state_id' => 843,
'name' => 'San José de Uré'
],[
'state_id' => 843,
'name' => 'Tuchín'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
