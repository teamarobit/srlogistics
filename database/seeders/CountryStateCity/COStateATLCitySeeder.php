<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateATLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 825,
'name' => 'Baranoa'
],[
'state_id' => 825,
'name' => 'Barranquilla'
],[
'state_id' => 825,
'name' => 'Campo de la Cruz'
],[
'state_id' => 825,
'name' => 'Candelaria'
],[
'state_id' => 825,
'name' => 'Galapa'
],[
'state_id' => 825,
'name' => 'Juan de Acosta'
],[
'state_id' => 825,
'name' => 'Luruaco'
],[
'state_id' => 825,
'name' => 'Malambo'
],[
'state_id' => 825,
'name' => 'Manatí'
],[
'state_id' => 825,
'name' => 'Palmar de Varela'
],[
'state_id' => 825,
'name' => 'Piojó'
],[
'state_id' => 825,
'name' => 'Polonuevo'
],[
'state_id' => 825,
'name' => 'Ponedera'
],[
'state_id' => 825,
'name' => 'Puerto Colombia'
],[
'state_id' => 825,
'name' => 'Repelón'
],[
'state_id' => 825,
'name' => 'Sabanagrande'
],[
'state_id' => 825,
'name' => 'Sabanalarga'
],[
'state_id' => 825,
'name' => 'Santa Lucía'
],[
'state_id' => 825,
'name' => 'Santo Tomás'
],[
'state_id' => 825,
'name' => 'Soledad'
],[
'state_id' => 825,
'name' => 'Suan'
],[
'state_id' => 825,
'name' => 'Tubará'
],[
'state_id' => 825,
'name' => 'Usiacurí'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
