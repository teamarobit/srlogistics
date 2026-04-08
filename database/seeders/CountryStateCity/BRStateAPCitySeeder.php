<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BRStateAPCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 526,
'name' => 'Amapá'
],[
'state_id' => 526,
'name' => 'Calçoene'
],[
'state_id' => 526,
'name' => 'Cutias'
],[
'state_id' => 526,
'name' => 'Ferreira Gomes'
],[
'state_id' => 526,
'name' => 'Itaubal'
],[
'state_id' => 526,
'name' => 'Laranjal do Jari'
],[
'state_id' => 526,
'name' => 'Macapá'
],[
'state_id' => 526,
'name' => 'Mazagão'
],[
'state_id' => 526,
'name' => 'Oiapoque'
],[
'state_id' => 526,
'name' => 'Pedra Branca do Amapari'
],[
'state_id' => 526,
'name' => 'Porto Grande'
],[
'state_id' => 526,
'name' => 'Pracuúba'
],[
'state_id' => 526,
'name' => 'Santana'
],[
'state_id' => 526,
'name' => 'Serra do Navio'
],[
'state_id' => 526,
'name' => 'Tartarugalzinho'
],[
'state_id' => 526,
'name' => 'Vitória do Jari'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
