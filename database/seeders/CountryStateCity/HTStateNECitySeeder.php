<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HTStateNECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1587,
'name' => 'Arrondissement de Fort Liberté'
],[
'state_id' => 1587,
'name' => 'Arrondissement du Trou du Nord'
],[
'state_id' => 1587,
'name' => 'Caracol'
],[
'state_id' => 1587,
'name' => 'Carice'
],[
'state_id' => 1587,
'name' => 'Dérac'
],[
'state_id' => 1587,
'name' => 'Ferrier'
],[
'state_id' => 1587,
'name' => 'Fort Liberté'
],[
'state_id' => 1587,
'name' => 'Montòrganize'
],[
'state_id' => 1587,
'name' => 'Ouanaminthe'
],[
'state_id' => 1587,
'name' => 'Perches'
],[
'state_id' => 1587,
'name' => 'Phaëton'
],[
'state_id' => 1587,
'name' => 'Trou du Nord'
],[
'state_id' => 1587,
'name' => 'Wanament'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
