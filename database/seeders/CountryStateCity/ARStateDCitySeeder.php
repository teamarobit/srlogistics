<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ARStateDCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 173,
'name' => 'Buena Esperanza'
],[
'state_id' => 173,
'name' => 'Candelaria'
],[
'state_id' => 173,
'name' => 'Concarán'
],[
'state_id' => 173,
'name' => 'Juan Martín de Pueyrredón'
],[
'state_id' => 173,
'name' => 'Justo Daract'
],[
'state_id' => 173,
'name' => 'La Punta'
],[
'state_id' => 173,
'name' => 'La Toma'
],[
'state_id' => 173,
'name' => 'Luján'
],[
'state_id' => 173,
'name' => 'Merlo'
],[
'state_id' => 173,
'name' => 'Naschel'
],[
'state_id' => 173,
'name' => 'San Francisco del Monte de Oro'
],[
'state_id' => 173,
'name' => 'San Luis'
],[
'state_id' => 173,
'name' => 'Santa Rosa del Conlara'
],[
'state_id' => 173,
'name' => 'Tilisarao'
],[
'state_id' => 173,
'name' => 'Unión'
],[
'state_id' => 173,
'name' => 'Villa General Roca'
],[
'state_id' => 173,
'name' => 'Villa Mercedes'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
