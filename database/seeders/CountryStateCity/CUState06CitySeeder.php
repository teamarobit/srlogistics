<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CUState06CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 967,
'name' => 'Abreus'
],[
'state_id' => 967,
'name' => 'Aguada de Pasajeros'
],[
'state_id' => 967,
'name' => 'Cienfuegos'
],[
'state_id' => 967,
'name' => 'Cruces'
],[
'state_id' => 967,
'name' => 'Cumanayagua'
],[
'state_id' => 967,
'name' => 'Lajas'
],[
'state_id' => 967,
'name' => 'Municipio de Abreus'
],[
'state_id' => 967,
'name' => 'Municipio de Cienfuegos'
],[
'state_id' => 967,
'name' => 'Palmira'
],[
'state_id' => 967,
'name' => 'Rodas'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
