<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateCAUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 829,
'name' => 'Almaguer'
],[
'state_id' => 829,
'name' => 'Argelia'
],[
'state_id' => 829,
'name' => 'Balboa'
],[
'state_id' => 829,
'name' => 'Bolívar'
],[
'state_id' => 829,
'name' => 'Buenos Aires'
],[
'state_id' => 829,
'name' => 'Cajibío'
],[
'state_id' => 829,
'name' => 'Caldono'
],[
'state_id' => 829,
'name' => 'Caloto'
],[
'state_id' => 829,
'name' => 'Corinto'
],[
'state_id' => 829,
'name' => 'El Tambo'
],[
'state_id' => 829,
'name' => 'Florencia'
],[
'state_id' => 829,
'name' => 'Guapi'
],[
'state_id' => 829,
'name' => 'Inzá'
],[
'state_id' => 829,
'name' => 'Jambaló'
],[
'state_id' => 829,
'name' => 'La Sierra'
],[
'state_id' => 829,
'name' => 'La Vega'
],[
'state_id' => 829,
'name' => 'López de Micay'
],[
'state_id' => 829,
'name' => 'Mercaderes'
],[
'state_id' => 829,
'name' => 'Miranda'
],[
'state_id' => 829,
'name' => 'Morales'
],[
'state_id' => 829,
'name' => 'Padilla'
],[
'state_id' => 829,
'name' => 'Páez'
],[
'state_id' => 829,
'name' => 'Patía'
],[
'state_id' => 829,
'name' => 'Piendamo'
],[
'state_id' => 829,
'name' => 'Popayán'
],[
'state_id' => 829,
'name' => 'Puerto Tejada'
],[
'state_id' => 829,
'name' => 'Puracé'
],[
'state_id' => 829,
'name' => 'Rosas'
],[
'state_id' => 829,
'name' => 'San Sebastián'
],[
'state_id' => 829,
'name' => 'Santander de Quilichao'
],[
'state_id' => 829,
'name' => 'Silvia'
],[
'state_id' => 829,
'name' => 'Sotará'
],[
'state_id' => 829,
'name' => 'Sucre'
],[
'state_id' => 829,
'name' => 'Suárez'
],[
'state_id' => 829,
'name' => 'Timbiquí'
],[
'state_id' => 829,
'name' => 'Toribio'
],[
'state_id' => 829,
'name' => 'Totoró'
],[
'state_id' => 829,
'name' => 'Villa Rica'
],[
'state_id' => 829,
'name' => 'Guachené'
],[
'state_id' => 829,
'name' => 'Piamonte'
],[
'state_id' => 829,
'name' => 'Santa Rosa'
],[
'state_id' => 829,
'name' => 'Timbío'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
