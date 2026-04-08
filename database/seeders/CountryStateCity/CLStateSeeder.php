<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class CLStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 44,
'name' => 'Atacama',
'iso2' => 'AT'
],[
'country_id' => 44,
'name' => 'Región Metropolitana de Santiago',
'iso2' => 'RM'
],[
'country_id' => 44,
'name' => 'Coquimbo',
'iso2' => 'CO'
],[
'country_id' => 44,
'name' => 'La Araucanía',
'iso2' => 'AR'
],[
'country_id' => 44,
'name' => 'Biobío',
'iso2' => 'BI'
],[
'country_id' => 44,
'name' => 'Aisén del General Carlos Ibañez del Campo',
'iso2' => 'AI'
],[
'country_id' => 44,
'name' => 'Arica y Parinacota',
'iso2' => 'AP'
],[
'country_id' => 44,
'name' => 'Valparaíso',
'iso2' => 'VS'
],[
'country_id' => 44,
'name' => 'Ñuble',
'iso2' => 'NB'
],[
'country_id' => 44,
'name' => 'Antofagasta',
'iso2' => 'AN'
],[
'country_id' => 44,
'name' => 'Maule',
'iso2' => 'ML'
],[
'country_id' => 44,
'name' => 'Los Ríos',
'iso2' => 'LR'
],[
'country_id' => 44,
'name' => 'Los Lagos',
'iso2' => 'LL'
],[
'country_id' => 44,
'name' => 'Magallanes y de la Antártica Chilena',
'iso2' => 'MA'
],[
'country_id' => 44,
'name' => 'Tarapacá',
'iso2' => 'TA'
],[
'country_id' => 44,
'name' => 'Libertador General Bernardo O Higgins',
'iso2' => 'LI'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
