<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GRStateCCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1469,
'name' => 'Aianí'
],[
'state_id' => 1469,
'name' => 'Akriní'
],[
'state_id' => 1469,
'name' => 'Ammochóri'
],[
'state_id' => 1469,
'name' => 'Amýntaio'
],[
'state_id' => 1469,
'name' => 'Anaráchi'
],[
'state_id' => 1469,
'name' => 'Argos Orestiko'
],[
'state_id' => 1469,
'name' => 'Chlói'
],[
'state_id' => 1469,
'name' => 'Deskáti'
],[
'state_id' => 1469,
'name' => 'Empório'
],[
'state_id' => 1469,
'name' => 'Erátyra'
],[
'state_id' => 1469,
'name' => 'Filótas'
],[
'state_id' => 1469,
'name' => 'Flórina'
],[
'state_id' => 1469,
'name' => 'Galatiní'
],[
'state_id' => 1469,
'name' => 'Grevená'
],[
'state_id' => 1469,
'name' => 'Kastoria'
],[
'state_id' => 1469,
'name' => 'Kleítos'
],[
'state_id' => 1469,
'name' => 'Komniná'
],[
'state_id' => 1469,
'name' => 'Kozáni'
],[
'state_id' => 1469,
'name' => 'Koíla'
],[
'state_id' => 1469,
'name' => 'Krókos'
],[
'state_id' => 1469,
'name' => 'Laimós'
],[
'state_id' => 1469,
'name' => 'Livaderó'
],[
'state_id' => 1469,
'name' => 'Léchovo'
],[
'state_id' => 1469,
'name' => 'Maniákoi'
],[
'state_id' => 1469,
'name' => 'Mavrochóri'
],[
'state_id' => 1469,
'name' => 'Melíti'
],[
'state_id' => 1469,
'name' => 'Mesopotamía'
],[
'state_id' => 1469,
'name' => 'Nea Lava'
],[
'state_id' => 1469,
'name' => 'Nestório'
],[
'state_id' => 1469,
'name' => 'Nomós Kozánis'
],[
'state_id' => 1469,
'name' => 'Platanórevma'
],[
'state_id' => 1469,
'name' => 'Ptolemaḯda'
],[
'state_id' => 1469,
'name' => 'Siátista'
],[
'state_id' => 1469,
'name' => 'Sérvia'
],[
'state_id' => 1469,
'name' => 'Tsotíli'
],[
'state_id' => 1469,
'name' => 'Velventós'
],[
'state_id' => 1469,
'name' => 'Xinó Neró'
],[
'state_id' => 1469,
'name' => 'Áno Kómi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
