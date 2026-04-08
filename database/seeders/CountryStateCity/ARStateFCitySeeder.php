<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStateFCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 190,
'name' => 'Arauco'
],[
'state_id' => 190,
'name' => 'Castro Barros'
],[
'state_id' => 190,
'name' => 'Chamical'
],[
'state_id' => 190,
'name' => 'Chilecito'
],[
'state_id' => 190,
'name' => 'Departamento de Arauco'
],[
'state_id' => 190,
'name' => 'Departamento de General Lamadrid'
],[
'state_id' => 190,
'name' => 'Departamento de Independencia'
],[
'state_id' => 190,
'name' => 'La Rioja'
],[
'state_id' => 190,
'name' => 'Villa Bustos'
],[
'state_id' => 190,
'name' => 'Vinchina'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
