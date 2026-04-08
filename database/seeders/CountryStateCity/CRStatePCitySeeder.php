<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CRStatePCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 894,
'name' => 'Buenos Aires'
],[
'state_id' => 894,
'name' => 'Canoas'
],[
'state_id' => 894,
'name' => 'Chacarita'
],[
'state_id' => 894,
'name' => 'Ciudad Cortés'
],[
'state_id' => 894,
'name' => 'Corredor'
],[
'state_id' => 894,
'name' => 'Corredores'
],[
'state_id' => 894,
'name' => 'Coto Brus'
],[
'state_id' => 894,
'name' => 'Esparza'
],[
'state_id' => 894,
'name' => 'Garabito'
],[
'state_id' => 894,
'name' => 'Golfito'
],[
'state_id' => 894,
'name' => 'Jacó'
],[
'state_id' => 894,
'name' => 'Miramar'
],[
'state_id' => 894,
'name' => 'Montes de Oro'
],[
'state_id' => 894,
'name' => 'Osa'
],[
'state_id' => 894,
'name' => 'Paquera'
],[
'state_id' => 894,
'name' => 'Parrita'
],[
'state_id' => 894,
'name' => 'Puntarenas'
],[
'state_id' => 894,
'name' => 'Quepos'
],[
'state_id' => 894,
'name' => 'San Vito'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
