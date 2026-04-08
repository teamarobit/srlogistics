<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BFState12CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 585,
'name' => 'Djibo'
],[
'state_id' => 585,
'name' => 'Dori'
],[
'state_id' => 585,
'name' => 'Gorom-Gorom'
],[
'state_id' => 585,
'name' => 'Province de l’Oudalan'
],[
'state_id' => 585,
'name' => 'Province du Soum'
],[
'state_id' => 585,
'name' => 'Province du Séno'
],[
'state_id' => 585,
'name' => 'Province du Yagha'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
