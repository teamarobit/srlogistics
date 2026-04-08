<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HTStateNICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1584,
'name' => 'Ansavo'
],[
'state_id' => 1584,
'name' => 'Baradères'
],[
'state_id' => 1584,
'name' => 'Miragoâne'
],[
'state_id' => 1584,
'name' => 'Petit Trou de Nippes'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
