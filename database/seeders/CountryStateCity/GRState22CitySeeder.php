<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GRState22CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1485,
'name' => 'Farkadóna'
],[
'state_id' => 1485,
'name' => 'Fíki'
],[
'state_id' => 1485,
'name' => 'Grizáno'
],[
'state_id' => 1485,
'name' => 'Gómfoi'
],[
'state_id' => 1485,
'name' => 'Kalampáka'
],[
'state_id' => 1485,
'name' => 'Kastráki'
],[
'state_id' => 1485,
'name' => 'Megalochóri'
],[
'state_id' => 1485,
'name' => 'Megála Kalývia'
],[
'state_id' => 1485,
'name' => 'Oichalía'
],[
'state_id' => 1485,
'name' => 'Palaiomonástiro'
],[
'state_id' => 1485,
'name' => 'Palaiópyrgos'
],[
'state_id' => 1485,
'name' => 'Pigí'
],[
'state_id' => 1485,
'name' => 'Pyrgetós'
],[
'state_id' => 1485,
'name' => 'Pýli'
],[
'state_id' => 1485,
'name' => 'Rízoma'
],[
'state_id' => 1485,
'name' => 'Taxiárches'
],[
'state_id' => 1485,
'name' => 'Tríkala'
],[
'state_id' => 1485,
'name' => 'Vasilikí'
],[
'state_id' => 1485,
'name' => 'Zárkos'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
