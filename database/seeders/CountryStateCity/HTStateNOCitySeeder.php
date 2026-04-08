<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HTStateNOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1592,
'name' => 'Arcahaie'
],[
'state_id' => 1592,
'name' => 'Arrondissement de Port-de-Paix'
],[
'state_id' => 1592,
'name' => 'Arrondissement de Saint-Louis du Nord'
],[
'state_id' => 1592,
'name' => 'Arrondissement du Môle Saint-Nicolas'
],[
'state_id' => 1592,
'name' => 'Baie de Henne'
],[
'state_id' => 1592,
'name' => 'Bombardopolis'
],[
'state_id' => 1592,
'name' => 'Fond Bassin Bleu'
],[
'state_id' => 1592,
'name' => 'Jean-Rabel'
],[
'state_id' => 1592,
'name' => 'Môle Saint-Nicolas'
],[
'state_id' => 1592,
'name' => 'Petite Anse'
],[
'state_id' => 1592,
'name' => 'Port-de-Paix'
],[
'state_id' => 1592,
'name' => 'Saint-Louis du Nord'
],[
'state_id' => 1592,
'name' => 'Ti Port-de-Paix'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
