<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HRState01CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 943,
'name' => 'Bestovje'
],[
'state_id' => 943,
'name' => 'Bistra'
],[
'state_id' => 943,
'name' => 'Brckovljani'
],[
'state_id' => 943,
'name' => 'Brdovec'
],[
'state_id' => 943,
'name' => 'Bregana'
],[
'state_id' => 943,
'name' => 'Donja Bistra'
],[
'state_id' => 943,
'name' => 'Donja Lomnica'
],[
'state_id' => 943,
'name' => 'Donja Zdenčina'
],[
'state_id' => 943,
'name' => 'Donji Stupnik'
],[
'state_id' => 943,
'name' => 'Farkaševac'
],[
'state_id' => 943,
'name' => 'Gornja Bistra'
],[
'state_id' => 943,
'name' => 'Grad Dugo Selo'
],[
'state_id' => 943,
'name' => 'Grad Jastrebarsko'
],[
'state_id' => 943,
'name' => 'Grad Samobor'
],[
'state_id' => 943,
'name' => 'Grad Sveti Ivan Zelina'
],[
'state_id' => 943,
'name' => 'Grad Velika Gorica'
],[
'state_id' => 943,
'name' => 'Grad Vrbovec'
],[
'state_id' => 943,
'name' => 'Grad Zaprešić'
],[
'state_id' => 943,
'name' => 'Gradec'
],[
'state_id' => 943,
'name' => 'Gradići'
],[
'state_id' => 943,
'name' => 'Gračec'
],[
'state_id' => 943,
'name' => 'Jablanovec'
],[
'state_id' => 943,
'name' => 'Jakovlje'
],[
'state_id' => 943,
'name' => 'Jastrebarsko'
],[
'state_id' => 943,
'name' => 'Kerestinec'
],[
'state_id' => 943,
'name' => 'Križ'
],[
'state_id' => 943,
'name' => 'Kuče'
],[
'state_id' => 943,
'name' => 'Lonjica'
],[
'state_id' => 943,
'name' => 'Luka'
],[
'state_id' => 943,
'name' => 'Lukavec'
],[
'state_id' => 943,
'name' => 'Lupoglav'
],[
'state_id' => 943,
'name' => 'Mičevec'
],[
'state_id' => 943,
'name' => 'Mraclin'
],[
'state_id' => 943,
'name' => 'Novo Čiče'
],[
'state_id' => 943,
'name' => 'Novoselec'
],[
'state_id' => 943,
'name' => 'Općina Dubrava'
],[
'state_id' => 943,
'name' => 'Orešje'
],[
'state_id' => 943,
'name' => 'Pojatno'
],[
'state_id' => 943,
'name' => 'Preseka'
],[
'state_id' => 943,
'name' => 'Prigorje Brdovečko'
],[
'state_id' => 943,
'name' => 'Pušća'
],[
'state_id' => 943,
'name' => 'Rakitje'
],[
'state_id' => 943,
'name' => 'Rakov Potok'
],[
'state_id' => 943,
'name' => 'Rude'
],[
'state_id' => 943,
'name' => 'Samobor'
],[
'state_id' => 943,
'name' => 'Stupnik'
],[
'state_id' => 943,
'name' => 'Sveta Nedelja'
],[
'state_id' => 943,
'name' => 'Sveta Nedjelja'
],[
'state_id' => 943,
'name' => 'Velika Gorica'
],[
'state_id' => 943,
'name' => 'Velika Mlaka'
],[
'state_id' => 943,
'name' => 'Velika Ostrna'
],[
'state_id' => 943,
'name' => 'Vrbovec'
],[
'state_id' => 943,
'name' => 'Zaprešić'
],[
'state_id' => 943,
'name' => 'Zdenci Brdovečki'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
