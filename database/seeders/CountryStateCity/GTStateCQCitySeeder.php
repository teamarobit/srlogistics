<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GTStateCQCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1510,
'name' => 'Camotán'
],[
'state_id' => 1510,
'name' => 'Chiquimula'
],[
'state_id' => 1510,
'name' => 'Concepción Las Minas'
],[
'state_id' => 1510,
'name' => 'Esquipulas'
],[
'state_id' => 1510,
'name' => 'Ipala'
],[
'state_id' => 1510,
'name' => 'Jocotán'
],[
'state_id' => 1510,
'name' => 'Olopa'
],[
'state_id' => 1510,
'name' => 'Quezaltepeque'
],[
'state_id' => 1510,
'name' => 'San Jacinto'
],[
'state_id' => 1510,
'name' => 'San José La Arada'
],[
'state_id' => 1510,
'name' => 'San Juan Ermita'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
