<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CRStateACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 899,
'name' => 'Alajuela'
],[
'state_id' => 899,
'name' => 'Atenas'
],[
'state_id' => 899,
'name' => 'Bijagua'
],[
'state_id' => 899,
'name' => 'Carrillos'
],[
'state_id' => 899,
'name' => 'Desamparados'
],[
'state_id' => 899,
'name' => 'Esquipulas'
],[
'state_id' => 899,
'name' => 'Grecia'
],[
'state_id' => 899,
'name' => 'Guatuso'
],[
'state_id' => 899,
'name' => 'La Fortuna'
],[
'state_id' => 899,
'name' => 'Los Chiles'
],[
'state_id' => 899,
'name' => 'Naranjo'
],[
'state_id' => 899,
'name' => 'Orotina'
],[
'state_id' => 899,
'name' => 'Palmares'
],[
'state_id' => 899,
'name' => 'Pital'
],[
'state_id' => 899,
'name' => 'Pocosol'
],[
'state_id' => 899,
'name' => 'Poás'
],[
'state_id' => 899,
'name' => 'Quesada'
],[
'state_id' => 899,
'name' => 'Río Segundo'
],[
'state_id' => 899,
'name' => 'Sabanilla'
],[
'state_id' => 899,
'name' => 'San Carlos'
],[
'state_id' => 899,
'name' => 'San José'
],[
'state_id' => 899,
'name' => 'San Juan'
],[
'state_id' => 899,
'name' => 'San Mateo'
],[
'state_id' => 899,
'name' => 'San Rafael'
],[
'state_id' => 899,
'name' => 'San Ramón'
],[
'state_id' => 899,
'name' => 'Santiago'
],[
'state_id' => 899,
'name' => 'Upala'
],[
'state_id' => 899,
'name' => 'Valverde Vega'
],[
'state_id' => 899,
'name' => 'Zarcero'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
