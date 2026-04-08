<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateMAGCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 831,
'name' => 'Algarrobo'
],[
'state_id' => 831,
'name' => 'Aracataca'
],[
'state_id' => 831,
'name' => 'Ariguaní'
],[
'state_id' => 831,
'name' => 'San Sebastián de Buenavista'
],[
'state_id' => 831,
'name' => 'Cerro de San Antonio'
],[
'state_id' => 831,
'name' => 'Chivolo'
],[
'state_id' => 831,
'name' => 'Ciénaga'
],[
'state_id' => 831,
'name' => 'Concordia'
],[
'state_id' => 831,
'name' => 'El Banco'
],[
'state_id' => 831,
'name' => 'El Piñon'
],[
'state_id' => 831,
'name' => 'El Retén'
],[
'state_id' => 831,
'name' => 'Fundación'
],[
'state_id' => 831,
'name' => 'Guamal'
],[
'state_id' => 831,
'name' => 'Nueva Granada'
],[
'state_id' => 831,
'name' => 'Pedraza'
],[
'state_id' => 831,
'name' => 'Pijiño del Carmen'
],[
'state_id' => 831,
'name' => 'Pivijay'
],[
'state_id' => 831,
'name' => 'Plato'
],[
'state_id' => 831,
'name' => 'Puebloviejo'
],[
'state_id' => 831,
'name' => 'Remolino'
],[
'state_id' => 831,
'name' => 'Sabanas de San Angel'
],[
'state_id' => 831,
'name' => 'Salamina'
],[
'state_id' => 831,
'name' => 'San Zenón'
],[
'state_id' => 831,
'name' => 'Santa Ana'
],[
'state_id' => 831,
'name' => 'Santa Bárbara de Pinto'
],[
'state_id' => 831,
'name' => 'Santa Marta'
],[
'state_id' => 831,
'name' => 'Sitionuevo'
],[
'state_id' => 831,
'name' => 'Tenerife'
],[
'state_id' => 831,
'name' => 'Zapayán'
],[
'state_id' => 831,
'name' => 'Zona Bananera'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
