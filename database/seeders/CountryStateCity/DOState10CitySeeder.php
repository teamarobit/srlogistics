<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState10CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1096,
'name' => 'Cristóbal'
],[
'state_id' => 1096,
'name' => 'Duvergé'
],[
'state_id' => 1096,
'name' => 'Guayabal'
],[
'state_id' => 1096,
'name' => 'Jimaní'
],[
'state_id' => 1096,
'name' => 'La Descubierta'
],[
'state_id' => 1096,
'name' => 'Mella'
],[
'state_id' => 1096,
'name' => 'Postrer Río'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
