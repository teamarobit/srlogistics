<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class SVStateSSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1185,
'name' => 'Aguilares'
],[
'state_id' => 1185,
'name' => 'Apopa'
],[
'state_id' => 1185,
'name' => 'Ayutuxtepeque'
],[
'state_id' => 1185,
'name' => 'Cuscatancingo'
],[
'state_id' => 1185,
'name' => 'Delgado'
],[
'state_id' => 1185,
'name' => 'El Paisnal'
],[
'state_id' => 1185,
'name' => 'Guazapa'
],[
'state_id' => 1185,
'name' => 'Ilopango'
],[
'state_id' => 1185,
'name' => 'Mejicanos'
],[
'state_id' => 1185,
'name' => 'Panchimalco'
],[
'state_id' => 1185,
'name' => 'Rosario de Mora'
],[
'state_id' => 1185,
'name' => 'San Marcos'
],[
'state_id' => 1185,
'name' => 'San Salvador'
],[
'state_id' => 1185,
'name' => 'Santo Tomás'
],[
'state_id' => 1185,
'name' => 'Soyapango'
],[
'state_id' => 1185,
'name' => 'Tonacatepeque'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
