<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GTStateHUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1514,
'name' => 'Aguacatán'
],[
'state_id' => 1514,
'name' => 'Barillas'
],[
'state_id' => 1514,
'name' => 'Chiantla'
],[
'state_id' => 1514,
'name' => 'Colotenango'
],[
'state_id' => 1514,
'name' => 'Concepción Huista'
],[
'state_id' => 1514,
'name' => 'Cuilco'
],[
'state_id' => 1514,
'name' => 'Huehuetenango'
],[
'state_id' => 1514,
'name' => 'Ixtahuacán'
],[
'state_id' => 1514,
'name' => 'Jacaltenango'
],[
'state_id' => 1514,
'name' => 'La Libertad'
],[
'state_id' => 1514,
'name' => 'Malacatancito'
],[
'state_id' => 1514,
'name' => 'Nentón'
],[
'state_id' => 1514,
'name' => 'San Antonio Huista'
],[
'state_id' => 1514,
'name' => 'San Gaspar Ixchil'
],[
'state_id' => 1514,
'name' => 'San Juan Atitán'
],[
'state_id' => 1514,
'name' => 'San Juan Ixcoy'
],[
'state_id' => 1514,
'name' => 'San Mateo Ixtatán'
],[
'state_id' => 1514,
'name' => 'San Miguel Acatán'
],[
'state_id' => 1514,
'name' => 'San Pedro Necta'
],[
'state_id' => 1514,
'name' => 'San Rafael La Independencia'
],[
'state_id' => 1514,
'name' => 'San Rafael Petzal'
],[
'state_id' => 1514,
'name' => 'San Sebastián Coatán'
],[
'state_id' => 1514,
'name' => 'San Sebastián Huehuetenango'
],[
'state_id' => 1514,
'name' => 'Santa Ana Huista'
],[
'state_id' => 1514,
'name' => 'Santa Bárbara'
],[
'state_id' => 1514,
'name' => 'Santa Eulalia'
],[
'state_id' => 1514,
'name' => 'Santiago Chimaltenango'
],[
'state_id' => 1514,
'name' => 'Soloma'
],[
'state_id' => 1514,
'name' => 'Tectitán'
],[
'state_id' => 1514,
'name' => 'Todos Santos Cuchumatán'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
