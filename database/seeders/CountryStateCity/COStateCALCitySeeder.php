<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateCALCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 832,
'name' => 'Aguadas'
],[
'state_id' => 832,
'name' => 'Anserma'
],[
'state_id' => 832,
'name' => 'Aranzazu'
],[
'state_id' => 832,
'name' => 'Belalcázar'
],[
'state_id' => 832,
'name' => 'Chinchiná'
],[
'state_id' => 832,
'name' => 'Filadelfia'
],[
'state_id' => 832,
'name' => 'La Dorada'
],[
'state_id' => 832,
'name' => 'La Merced'
],[
'state_id' => 832,
'name' => 'Manizales'
],[
'state_id' => 832,
'name' => 'Manzanares'
],[
'state_id' => 832,
'name' => 'Marmato'
],[
'state_id' => 832,
'name' => 'Marquetalia'
],[
'state_id' => 832,
'name' => 'Marulanda'
],[
'state_id' => 832,
'name' => 'Neira'
],[
'state_id' => 832,
'name' => 'Norcasia'
],[
'state_id' => 832,
'name' => 'Palestina'
],[
'state_id' => 832,
'name' => 'Pensilvania'
],[
'state_id' => 832,
'name' => 'Pácora'
],[
'state_id' => 832,
'name' => 'Riosucio'
],[
'state_id' => 832,
'name' => 'Risaralda'
],[
'state_id' => 832,
'name' => 'Salamina'
],[
'state_id' => 832,
'name' => 'Samaná'
],[
'state_id' => 832,
'name' => 'San José'
],[
'state_id' => 832,
'name' => 'Supía'
],[
'state_id' => 832,
'name' => 'Victoria'
],[
'state_id' => 832,
'name' => 'Villamaría'
],[
'state_id' => 832,
'name' => 'Viterbo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
