<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HTStateNDCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1583,
'name' => 'Acul du Nord'
],[
'state_id' => 1583,
'name' => 'Arrondissement de Plaisance'
],[
'state_id' => 1583,
'name' => 'Arrondissement de la Grande Rivière du Nord'
],[
'state_id' => 1583,
'name' => 'Arrondissement du Borgne'
],[
'state_id' => 1583,
'name' => 'Bahon'
],[
'state_id' => 1583,
'name' => 'Borgne'
],[
'state_id' => 1583,
'name' => 'Dondon'
],[
'state_id' => 1583,
'name' => 'Grande Rivière du Nord'
],[
'state_id' => 1583,
'name' => 'Lenbe'
],[
'state_id' => 1583,
'name' => 'Limonade'
],[
'state_id' => 1583,
'name' => 'Milot'
],[
'state_id' => 1583,
'name' => 'Okap'
],[
'state_id' => 1583,
'name' => 'Pignon'
],[
'state_id' => 1583,
'name' => 'Pilate'
],[
'state_id' => 1583,
'name' => 'Plaine du Nord'
],[
'state_id' => 1583,
'name' => 'Plaisance'
],[
'state_id' => 1583,
'name' => 'Port-Margot'
],[
'state_id' => 1583,
'name' => 'Quartier Morin'
],[
'state_id' => 1583,
'name' => 'Ranquitte'
],[
'state_id' => 1583,
'name' => 'Saint-Raphaël'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
