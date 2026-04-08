<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HTStateSDCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1588,
'name' => 'Aquin'
],[
'state_id' => 1588,
'name' => 'Arrondissement de Port-Salut'
],[
'state_id' => 1588,
'name' => 'Arrondissement des Cayes'
],[
'state_id' => 1588,
'name' => 'Cavaillon'
],[
'state_id' => 1588,
'name' => 'Chantal'
],[
'state_id' => 1588,
'name' => 'Chardonnière'
],[
'state_id' => 1588,
'name' => 'Fond des Blancs'
],[
'state_id' => 1588,
'name' => 'Koto'
],[
'state_id' => 1588,
'name' => 'Les Anglais'
],[
'state_id' => 1588,
'name' => 'Les Cayes'
],[
'state_id' => 1588,
'name' => 'Port-à-Piment'
],[
'state_id' => 1588,
'name' => 'Roche-à-Bateau'
],[
'state_id' => 1588,
'name' => 'Saint-Louis du Sud'
],[
'state_id' => 1588,
'name' => 'Tiburon'
],[
'state_id' => 1588,
'name' => 'Torbeck'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
