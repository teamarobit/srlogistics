<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateHUICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 850,
'name' => 'Acevedo'
],[
'state_id' => 850,
'name' => 'Aipe'
],[
'state_id' => 850,
'name' => 'Algeciras'
],[
'state_id' => 850,
'name' => 'Altamira'
],[
'state_id' => 850,
'name' => 'Baraya'
],[
'state_id' => 850,
'name' => 'Campoalegre'
],[
'state_id' => 850,
'name' => 'Colombia'
],[
'state_id' => 850,
'name' => 'El Agrado'
],[
'state_id' => 850,
'name' => 'Elias'
],[
'state_id' => 850,
'name' => 'Garzón'
],[
'state_id' => 850,
'name' => 'Gigante'
],[
'state_id' => 850,
'name' => 'Guadalupe'
],[
'state_id' => 850,
'name' => 'Hobo'
],[
'state_id' => 850,
'name' => 'Iquira'
],[
'state_id' => 850,
'name' => 'Isnos'
],[
'state_id' => 850,
'name' => 'La Plata'
],[
'state_id' => 850,
'name' => 'Nataga'
],[
'state_id' => 850,
'name' => 'Neiva'
],[
'state_id' => 850,
'name' => 'Oporapa'
],[
'state_id' => 850,
'name' => 'Paicol'
],[
'state_id' => 850,
'name' => 'Palermo'
],[
'state_id' => 850,
'name' => 'Palestina'
],[
'state_id' => 850,
'name' => 'Pital'
],[
'state_id' => 850,
'name' => 'Pitalito'
],[
'state_id' => 850,
'name' => 'Rivera'
],[
'state_id' => 850,
'name' => 'Saladoblanco'
],[
'state_id' => 850,
'name' => 'San Agustín'
],[
'state_id' => 850,
'name' => 'Santa María'
],[
'state_id' => 850,
'name' => 'Suaza'
],[
'state_id' => 850,
'name' => 'Tarqui'
],[
'state_id' => 850,
'name' => 'Tello'
],[
'state_id' => 850,
'name' => 'Teruel'
],[
'state_id' => 850,
'name' => 'Tesalia'
],[
'state_id' => 850,
'name' => 'Timana'
],[
'state_id' => 850,
'name' => 'Villavieja'
],[
'state_id' => 850,
'name' => 'Yaguará'
],[
'state_id' => 850,
'name' => 'La Argentina'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
