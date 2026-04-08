<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ECStateMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1136,
'name' => 'Bahía de Caráquez'
],[
'state_id' => 1136,
'name' => 'Calceta'
],[
'state_id' => 1136,
'name' => 'Cantón Portoviejo'
],[
'state_id' => 1136,
'name' => 'Chone'
],[
'state_id' => 1136,
'name' => 'Jipijapa'
],[
'state_id' => 1136,
'name' => 'Junín'
],[
'state_id' => 1136,
'name' => 'Manta'
],[
'state_id' => 1136,
'name' => 'Montecristi'
],[
'state_id' => 1136,
'name' => 'Paján'
],[
'state_id' => 1136,
'name' => 'Pedernales'
],[
'state_id' => 1136,
'name' => 'Portoviejo'
],[
'state_id' => 1136,
'name' => 'Rocafuerte'
],[
'state_id' => 1136,
'name' => 'San Vicente'
],[
'state_id' => 1136,
'name' => 'Santa Ana'
],[
'state_id' => 1136,
'name' => 'Sucre'
],[
'state_id' => 1136,
'name' => 'Tosagua'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
