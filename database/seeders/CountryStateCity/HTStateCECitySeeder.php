<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HTStateCECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1591,
'name' => 'Arrondissement de Cerca La Source'
],[
'state_id' => 1591,
'name' => 'Cerca la Source'
],[
'state_id' => 1591,
'name' => 'Hinche'
],[
'state_id' => 1591,
'name' => 'Lascahobas'
],[
'state_id' => 1591,
'name' => 'Mayisad'
],[
'state_id' => 1591,
'name' => 'Mirebalais'
],[
'state_id' => 1591,
'name' => 'Thomassique'
],[
'state_id' => 1591,
'name' => 'Thomonde'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
