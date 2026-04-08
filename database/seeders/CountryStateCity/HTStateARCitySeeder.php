<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HTStateARCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1589,
'name' => 'Anse Rouge'
],[
'state_id' => 1589,
'name' => 'Arrondissement de Saint-Marc'
],[
'state_id' => 1589,
'name' => 'Dessalines'
],[
'state_id' => 1589,
'name' => 'Désarmes'
],[
'state_id' => 1589,
'name' => 'Ennery'
],[
'state_id' => 1589,
'name' => 'Gonaïves'
],[
'state_id' => 1589,
'name' => 'Grande Saline'
],[
'state_id' => 1589,
'name' => 'Gros Morne'
],[
'state_id' => 1589,
'name' => 'Marmelade'
],[
'state_id' => 1589,
'name' => 'Saint-Marc'
],[
'state_id' => 1589,
'name' => 'Verrettes'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
