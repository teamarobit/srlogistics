<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HTStateOUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1586,
'name' => 'Anse à Galets'
],[
'state_id' => 1586,
'name' => 'Arcahaie'
],[
'state_id' => 1586,
'name' => 'Arrondissement de Croix des Bouquets'
],[
'state_id' => 1586,
'name' => 'Arrondissement de Léogâne'
],[
'state_id' => 1586,
'name' => 'Arrondissement de Port-au-Prince'
],[
'state_id' => 1586,
'name' => 'Cabaret'
],[
'state_id' => 1586,
'name' => 'Carrefour'
],[
'state_id' => 1586,
'name' => 'Cornillon'
],[
'state_id' => 1586,
'name' => 'Croix-des-Bouquets'
],[
'state_id' => 1586,
'name' => 'Delmas 73'
],[
'state_id' => 1586,
'name' => 'Fond Parisien'
],[
'state_id' => 1586,
'name' => 'Fonds Verrettes'
],[
'state_id' => 1586,
'name' => 'Grangwav'
],[
'state_id' => 1586,
'name' => 'Gressier'
],[
'state_id' => 1586,
'name' => 'Kenscoff'
],[
'state_id' => 1586,
'name' => 'Lagonav'
],[
'state_id' => 1586,
'name' => 'Léogâne'
],[
'state_id' => 1586,
'name' => 'Port-au-Prince'
],[
'state_id' => 1586,
'name' => 'Pétionville'
],[
'state_id' => 1586,
'name' => 'Thomazeau'
],[
'state_id' => 1586,
'name' => 'Tigwav'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
