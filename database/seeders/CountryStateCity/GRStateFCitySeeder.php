<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GRStateFCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1492,
'name' => 'Acharávi'
],[
'state_id' => 1492,
'name' => 'Agios Georgis'
],[
'state_id' => 1492,
'name' => 'Alepoú'
],[
'state_id' => 1492,
'name' => 'Ambelókipoi'
],[
'state_id' => 1492,
'name' => 'Argostólion'
],[
'state_id' => 1492,
'name' => 'Corfu'
],[
'state_id' => 1492,
'name' => 'Gaïtánion'
],[
'state_id' => 1492,
'name' => 'Gáïos'
],[
'state_id' => 1492,
'name' => 'Itháki'
],[
'state_id' => 1492,
'name' => 'Kanáli'
],[
'state_id' => 1492,
'name' => 'Katastárion'
],[
'state_id' => 1492,
'name' => 'Kontokáli'
],[
'state_id' => 1492,
'name' => 'Kynopiástes'
],[
'state_id' => 1492,
'name' => 'Lefkada'
],[
'state_id' => 1492,
'name' => 'Lefkímmi'
],[
'state_id' => 1492,
'name' => 'Lithakiá'
],[
'state_id' => 1492,
'name' => 'Lixoúri'
],[
'state_id' => 1492,
'name' => 'Mouzaki'
],[
'state_id' => 1492,
'name' => 'Nomós Kerkýras'
],[
'state_id' => 1492,
'name' => 'Nomós Zakýnthou'
],[
'state_id' => 1492,
'name' => 'Perama'
],[
'state_id' => 1492,
'name' => 'Perivóli'
],[
'state_id' => 1492,
'name' => 'Potamós'
],[
'state_id' => 1492,
'name' => 'Póros'
],[
'state_id' => 1492,
'name' => 'Sámi'
],[
'state_id' => 1492,
'name' => 'Valsamáta'
],[
'state_id' => 1492,
'name' => 'Vanáton'
],[
'state_id' => 1492,
'name' => 'Virós'
],[
'state_id' => 1492,
'name' => 'Zakynthos'
],[
'state_id' => 1492,
'name' => 'Ágios Matthaíos'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
