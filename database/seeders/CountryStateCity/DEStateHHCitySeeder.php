<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DEStateHHCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1434,
'name' => 'Alsterdorf'
],[
'state_id' => 1434,
'name' => 'Altona'
],[
'state_id' => 1434,
'name' => 'Barmbek-Nord'
],[
'state_id' => 1434,
'name' => 'Bergedorf'
],[
'state_id' => 1434,
'name' => 'Bergstedt'
],[
'state_id' => 1434,
'name' => 'Borgfelde'
],[
'state_id' => 1434,
'name' => 'Duvenstedt'
],[
'state_id' => 1434,
'name' => 'Eidelstedt'
],[
'state_id' => 1434,
'name' => 'Eimsbüttel'
],[
'state_id' => 1434,
'name' => 'Farmsen-Berne'
],[
'state_id' => 1434,
'name' => 'Fuhlsbüttel'
],[
'state_id' => 1434,
'name' => 'Hamburg'
],[
'state_id' => 1434,
'name' => 'Hamburg-Altstadt'
],[
'state_id' => 1434,
'name' => 'Hamburg-Mitte'
],[
'state_id' => 1434,
'name' => 'Hamburg-Nord'
],[
'state_id' => 1434,
'name' => 'Hammerbrook'
],[
'state_id' => 1434,
'name' => 'Harburg'
],[
'state_id' => 1434,
'name' => 'Hummelsbüttel'
],[
'state_id' => 1434,
'name' => 'Kleiner Grasbrook'
],[
'state_id' => 1434,
'name' => 'Langenhorn'
],[
'state_id' => 1434,
'name' => 'Lemsahl-Mellingstedt'
],[
'state_id' => 1434,
'name' => 'Lurup'
],[
'state_id' => 1434,
'name' => 'Marienthal'
],[
'state_id' => 1434,
'name' => 'Neustadt'
],[
'state_id' => 1434,
'name' => 'Ohlsdorf'
],[
'state_id' => 1434,
'name' => 'Ottensen'
],[
'state_id' => 1434,
'name' => 'Poppenbüttel'
],[
'state_id' => 1434,
'name' => 'Rothenburgsort'
],[
'state_id' => 1434,
'name' => 'Sasel'
],[
'state_id' => 1434,
'name' => 'St. Georg'
],[
'state_id' => 1434,
'name' => 'St. Pauli'
],[
'state_id' => 1434,
'name' => 'Steilshoop'
],[
'state_id' => 1434,
'name' => 'Stellingen'
],[
'state_id' => 1434,
'name' => 'Wandsbek'
],[
'state_id' => 1434,
'name' => 'Wellingsbüttel'
],[
'state_id' => 1434,
'name' => 'Winterhude'
],[
'state_id' => 1434,
'name' => 'Wohldorf-Ohlstedt'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
