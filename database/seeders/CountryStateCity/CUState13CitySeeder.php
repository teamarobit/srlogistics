<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CUState13CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 953,
'name' => 'Contramaestre'
],[
'state_id' => 953,
'name' => 'El Cobre'
],[
'state_id' => 953,
'name' => 'Municipio de Palma Soriano'
],[
'state_id' => 953,
'name' => 'Municipio de Santiago de Cuba'
],[
'state_id' => 953,
'name' => 'Palma Soriano'
],[
'state_id' => 953,
'name' => 'San Luis'
],[
'state_id' => 953,
'name' => 'Santiago de Cuba'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
