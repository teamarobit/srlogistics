<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateRISCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 824,
'name' => 'Apía'
],[
'state_id' => 824,
'name' => 'Balboa'
],[
'state_id' => 824,
'name' => 'Belén de Umbría'
],[
'state_id' => 824,
'name' => 'Dosquebradas'
],[
'state_id' => 824,
'name' => 'Guática'
],[
'state_id' => 824,
'name' => 'La Celia'
],[
'state_id' => 824,
'name' => 'La Virginia'
],[
'state_id' => 824,
'name' => 'Marsella'
],[
'state_id' => 824,
'name' => 'Mistrató'
],[
'state_id' => 824,
'name' => 'Pereira'
],[
'state_id' => 824,
'name' => 'Pueblo Rico'
],[
'state_id' => 824,
'name' => 'Quinchía'
],[
'state_id' => 824,
'name' => 'Santa Rosa de Cabal'
],[
'state_id' => 824,
'name' => 'Santuario'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
