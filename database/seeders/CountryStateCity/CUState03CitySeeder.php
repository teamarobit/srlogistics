<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CUState03CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 952,
'name' => 'Alamar'
],[
'state_id' => 952,
'name' => 'Arroyo Naranjo'
],[
'state_id' => 952,
'name' => 'Boyeros'
],[
'state_id' => 952,
'name' => 'Centro Habana'
],[
'state_id' => 952,
'name' => 'Cerro'
],[
'state_id' => 952,
'name' => 'Diez de Octubre'
],[
'state_id' => 952,
'name' => 'Guanabacoa'
],[
'state_id' => 952,
'name' => 'Habana del Este'
],[
'state_id' => 952,
'name' => 'Havana'
],[
'state_id' => 952,
'name' => 'La Habana Vieja'
],[
'state_id' => 952,
'name' => 'Regla'
],[
'state_id' => 952,
'name' => 'San Miguel del Padrón'
],[
'state_id' => 952,
'name' => 'Santiago de las Vegas'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
