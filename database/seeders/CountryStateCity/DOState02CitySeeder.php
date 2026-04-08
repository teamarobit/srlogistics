<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState02CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1113,
'name' => 'Azua'
],[
'state_id' => 1113,
'name' => 'El Guayabal'
],[
'state_id' => 1113,
'name' => 'Estebanía'
],[
'state_id' => 1113,
'name' => 'Las Charcas'
],[
'state_id' => 1113,
'name' => 'Padre Las Casas'
],[
'state_id' => 1113,
'name' => 'Palmar de Ocoa'
],[
'state_id' => 1113,
'name' => 'Peralta'
],[
'state_id' => 1113,
'name' => 'Pueblo Viejo'
],[
'state_id' => 1113,
'name' => 'Sabana Yegua'
],[
'state_id' => 1113,
'name' => 'Tábara Arriba'
],[
'state_id' => 1113,
'name' => 'Villarpando'
],[
'state_id' => 1113,
'name' => 'Yayas de Viajama'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
