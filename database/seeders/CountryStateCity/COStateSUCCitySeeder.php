<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateSUCCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 847,
'name' => 'Caimito'
],[
'state_id' => 847,
'name' => 'Chalán'
],[
'state_id' => 847,
'name' => 'Coloso'
],[
'state_id' => 847,
'name' => 'Corozal'
],[
'state_id' => 847,
'name' => 'Coveñas'
],[
'state_id' => 847,
'name' => 'El Roble'
],[
'state_id' => 847,
'name' => 'Galeras'
],[
'state_id' => 847,
'name' => 'Guaranda'
],[
'state_id' => 847,
'name' => 'La Unión'
],[
'state_id' => 847,
'name' => 'Los Palmitos'
],[
'state_id' => 847,
'name' => 'Majagual'
],[
'state_id' => 847,
'name' => 'Morroa'
],[
'state_id' => 847,
'name' => 'Ovejas'
],[
'state_id' => 847,
'name' => 'Palmito'
],[
'state_id' => 847,
'name' => 'Sampués'
],[
'state_id' => 847,
'name' => 'San Benito Abad'
],[
'state_id' => 847,
'name' => 'San Juan de Betulia'
],[
'state_id' => 847,
'name' => 'San Luis de Sincé'
],[
'state_id' => 847,
'name' => 'San Marcos'
],[
'state_id' => 847,
'name' => 'San Onofre'
],[
'state_id' => 847,
'name' => 'San Pedro'
],[
'state_id' => 847,
'name' => 'Santiago de Tolú'
],[
'state_id' => 847,
'name' => 'Sincelejo'
],[
'state_id' => 847,
'name' => 'Sucre'
],[
'state_id' => 847,
'name' => 'Tolú Viejo'
],[
'state_id' => 847,
'name' => 'Buenavista'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
