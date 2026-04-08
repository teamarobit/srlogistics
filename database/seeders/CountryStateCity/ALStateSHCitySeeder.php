<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ALStateSHCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 67,
'name' => 'Bashkia Malësi e Madhe'
],[
'state_id' => 67,
'name' => 'Bashkia Pukë'
],[
'state_id' => 67,
'name' => 'Bashkia Vau i Dejës'
],[
'state_id' => 67,
'name' => 'Fushë-Arrëz'
],[
'state_id' => 67,
'name' => 'Koplik'
],[
'state_id' => 67,
'name' => 'Pukë'
],[
'state_id' => 67,
'name' => 'Rrethi i Malësia e Madhe'
],[
'state_id' => 67,
'name' => 'Rrethi i Shkodrës'
],[
'state_id' => 67,
'name' => 'Shkodër'
],[
'state_id' => 67,
'name' => 'Vau i Dejës'
],[
'state_id' => 67,
'name' => 'Vukatanë'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
