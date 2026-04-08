<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateCASCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 837,
'name' => 'Aguazul'
],[
'state_id' => 837,
'name' => 'Chameza'
],[
'state_id' => 837,
'name' => 'Hato Corozal'
],[
'state_id' => 837,
'name' => 'Maní'
],[
'state_id' => 837,
'name' => 'Monterrey'
],[
'state_id' => 837,
'name' => 'Nunchía'
],[
'state_id' => 837,
'name' => 'Orocué'
],[
'state_id' => 837,
'name' => 'Pore'
],[
'state_id' => 837,
'name' => 'Recetor'
],[
'state_id' => 837,
'name' => 'Sabanalarga'
],[
'state_id' => 837,
'name' => 'San Luis de Palenque'
],[
'state_id' => 837,
'name' => 'Sácama'
],[
'state_id' => 837,
'name' => 'Tauramena'
],[
'state_id' => 837,
'name' => 'Trinidad'
],[
'state_id' => 837,
'name' => 'Támara'
],[
'state_id' => 837,
'name' => 'Villanueva'
],[
'state_id' => 837,
'name' => 'Yopal'
],[
'state_id' => 837,
'name' => 'La Salina'
],[
'state_id' => 837,
'name' => 'Paz de Ariporo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
