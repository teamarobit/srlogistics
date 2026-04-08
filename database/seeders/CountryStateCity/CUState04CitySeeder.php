<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CUState04CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 964,
'name' => 'Alacranes'
],[
'state_id' => 964,
'name' => 'Bolondrón'
],[
'state_id' => 964,
'name' => 'Calimete'
],[
'state_id' => 964,
'name' => 'Colón'
],[
'state_id' => 964,
'name' => 'Cárdenas'
],[
'state_id' => 964,
'name' => 'Jagüey Grande'
],[
'state_id' => 964,
'name' => 'Jovellanos'
],[
'state_id' => 964,
'name' => 'Limonar'
],[
'state_id' => 964,
'name' => 'Los Arabos'
],[
'state_id' => 964,
'name' => 'Manguito'
],[
'state_id' => 964,
'name' => 'Martí'
],[
'state_id' => 964,
'name' => 'Matanzas'
],[
'state_id' => 964,
'name' => 'Municipio de Cárdenas'
],[
'state_id' => 964,
'name' => 'Municipio de Matanzas'
],[
'state_id' => 964,
'name' => 'Pedro Betancourt'
],[
'state_id' => 964,
'name' => 'Perico'
],[
'state_id' => 964,
'name' => 'Unión de Reyes'
],[
'state_id' => 964,
'name' => 'Varadero'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
