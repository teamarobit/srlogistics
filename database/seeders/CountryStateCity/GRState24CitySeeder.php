<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GRState24CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1465,
'name' => 'Agriá'
],[
'state_id' => 1465,
'name' => 'Almyrós'
],[
'state_id' => 1465,
'name' => 'Anakasiá'
],[
'state_id' => 1465,
'name' => 'Argalastí'
],[
'state_id' => 1465,
'name' => 'Evxinoúpolis'
],[
'state_id' => 1465,
'name' => 'Kanália'
],[
'state_id' => 1465,
'name' => 'Káto Lekhónia'
],[
'state_id' => 1465,
'name' => 'Néa Anchiálos'
],[
'state_id' => 1465,
'name' => 'Néa Ionía'
],[
'state_id' => 1465,
'name' => 'Patitírion'
],[
'state_id' => 1465,
'name' => 'Portariá'
],[
'state_id' => 1465,
'name' => 'Pteleós'
],[
'state_id' => 1465,
'name' => 'Rizómylos'
],[
'state_id' => 1465,
'name' => 'Skiáthos'
],[
'state_id' => 1465,
'name' => 'Skópelos'
],[
'state_id' => 1465,
'name' => 'Soúrpi'
],[
'state_id' => 1465,
'name' => 'Stefanovíkeio'
],[
'state_id' => 1465,
'name' => 'Tríkeri'
],[
'state_id' => 1465,
'name' => 'Velestíno'
],[
'state_id' => 1465,
'name' => 'Volos'
],[
'state_id' => 1465,
'name' => 'Zagorá'
],[
'state_id' => 1465,
'name' => 'Álli Meriá'
],[
'state_id' => 1465,
'name' => 'Áno Lekhónia'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
