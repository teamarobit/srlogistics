<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GRStateDCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1471,
'name' => 'Agía Kyriakí'
],[
'state_id' => 1471,
'name' => 'Anatolí'
],[
'state_id' => 1471,
'name' => 'Anéza'
],[
'state_id' => 1471,
'name' => 'Asprángeloi'
],[
'state_id' => 1471,
'name' => 'Chalkiádes'
],[
'state_id' => 1471,
'name' => 'Eksochí'
],[
'state_id' => 1471,
'name' => 'Eleoúsa'
],[
'state_id' => 1471,
'name' => 'Filippiáda'
],[
'state_id' => 1471,
'name' => 'Filiátes'
],[
'state_id' => 1471,
'name' => 'Graikochóri'
],[
'state_id' => 1471,
'name' => 'Grammenítsa'
],[
'state_id' => 1471,
'name' => 'Igoumenítsa'
],[
'state_id' => 1471,
'name' => 'Ioánnina'
],[
'state_id' => 1471,
'name' => 'Kalamiá'
],[
'state_id' => 1471,
'name' => 'Kalpáki'
],[
'state_id' => 1471,
'name' => 'Kanaláki'
],[
'state_id' => 1471,
'name' => 'Kardamítsia'
],[
'state_id' => 1471,
'name' => 'Katsikás'
],[
'state_id' => 1471,
'name' => 'Kompóti'
],[
'state_id' => 1471,
'name' => 'Kostakioí'
],[
'state_id' => 1471,
'name' => 'Koutselió'
],[
'state_id' => 1471,
'name' => 'Kónitsa'
],[
'state_id' => 1471,
'name' => 'Loúros'
],[
'state_id' => 1471,
'name' => 'Metsovo'
],[
'state_id' => 1471,
'name' => 'Neochorópoulo'
],[
'state_id' => 1471,
'name' => 'Neochóri'
],[
'state_id' => 1471,
'name' => 'Nomós Ioannínon'
],[
'state_id' => 1471,
'name' => 'Néa Seléfkeia'
],[
'state_id' => 1471,
'name' => 'Néos Oropós'
],[
'state_id' => 1471,
'name' => 'Pappadátes'
],[
'state_id' => 1471,
'name' => 'Paramythiá'
],[
'state_id' => 1471,
'name' => 'Parapótamos'
],[
'state_id' => 1471,
'name' => 'Pediní'
],[
'state_id' => 1471,
'name' => 'Platariá'
],[
'state_id' => 1471,
'name' => 'Prámanta'
],[
'state_id' => 1471,
'name' => 'Préveza'
],[
'state_id' => 1471,
'name' => 'Párga'
],[
'state_id' => 1471,
'name' => 'Pérama'
],[
'state_id' => 1471,
'name' => 'Pérdika'
],[
'state_id' => 1471,
'name' => 'Péta'
],[
'state_id' => 1471,
'name' => 'Rodotópi'
],[
'state_id' => 1471,
'name' => 'Stavráki'
],[
'state_id' => 1471,
'name' => 'Thesprotikó'
],[
'state_id' => 1471,
'name' => 'Tsiflikópoulo'
],[
'state_id' => 1471,
'name' => 'Voulgaréli'
],[
'state_id' => 1471,
'name' => 'Vounoplagiá'
],[
'state_id' => 1471,
'name' => 'Áno Kalentíni'
],[
'state_id' => 1471,
'name' => 'Árta'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
