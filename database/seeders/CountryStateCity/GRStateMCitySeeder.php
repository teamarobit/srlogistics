<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GRStateMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1470,
'name' => 'Agía Foteiní'
],[
'state_id' => 1470,
'name' => 'Agía Galíni'
],[
'state_id' => 1470,
'name' => 'Agía Marína'
],[
'state_id' => 1470,
'name' => 'Agía Varvára'
],[
'state_id' => 1470,
'name' => 'Ano Arhanes'
],[
'state_id' => 1470,
'name' => 'Anógeia'
],[
'state_id' => 1470,
'name' => 'Arkalochóri'
],[
'state_id' => 1470,
'name' => 'Asímion'
],[
'state_id' => 1470,
'name' => 'Atsipópoulo'
],[
'state_id' => 1470,
'name' => 'Chaniá'
],[
'state_id' => 1470,
'name' => 'Chóra Sfakíon'
],[
'state_id' => 1470,
'name' => 'Darátsos'
],[
'state_id' => 1470,
'name' => 'Eloúnda'
],[
'state_id' => 1470,
'name' => 'Galatás'
],[
'state_id' => 1470,
'name' => 'Georgioupolis'
],[
'state_id' => 1470,
'name' => 'Geráni'
],[
'state_id' => 1470,
'name' => 'Goúrnes'
],[
'state_id' => 1470,
'name' => 'Gra Liyiá'
],[
'state_id' => 1470,
'name' => 'Gázi'
],[
'state_id' => 1470,
'name' => 'Gérgeri'
],[
'state_id' => 1470,
'name' => 'Ierápetra'
],[
'state_id' => 1470,
'name' => 'Irákleion'
],[
'state_id' => 1470,
'name' => 'Kalýves'
],[
'state_id' => 1470,
'name' => 'Kastrí'
],[
'state_id' => 1470,
'name' => 'Kastélli'
],[
'state_id' => 1470,
'name' => 'Kentrí'
],[
'state_id' => 1470,
'name' => 'Kokkíni Cháni'
],[
'state_id' => 1470,
'name' => 'Kolympári'
],[
'state_id' => 1470,
'name' => 'Kritsá'
],[
'state_id' => 1470,
'name' => 'Krousón'
],[
'state_id' => 1470,
'name' => 'Káto Asítai'
],[
'state_id' => 1470,
'name' => 'Káto Goúves'
],[
'state_id' => 1470,
'name' => 'Kíssamos'
],[
'state_id' => 1470,
'name' => 'Limín Khersonísou'
],[
'state_id' => 1470,
'name' => 'Mokhós'
],[
'state_id' => 1470,
'name' => 'Mourniés'
],[
'state_id' => 1470,
'name' => 'Mouzourás'
],[
'state_id' => 1470,
'name' => 'Moíres'
],[
'state_id' => 1470,
'name' => 'Mália'
],[
'state_id' => 1470,
'name' => 'Nerokoúros'
],[
'state_id' => 1470,
'name' => 'Neápoli'
],[
'state_id' => 1470,
'name' => 'Nomós Irakleíou'
],[
'state_id' => 1470,
'name' => 'Nomós Rethýmnis'
],[
'state_id' => 1470,
'name' => 'Néa Alikarnassós'
],[
'state_id' => 1470,
'name' => 'Néa Anatolí'
],[
'state_id' => 1470,
'name' => 'Palaióchora'
],[
'state_id' => 1470,
'name' => 'Palekastro'
],[
'state_id' => 1470,
'name' => 'Perivólia'
],[
'state_id' => 1470,
'name' => 'Pithári'
],[
'state_id' => 1470,
'name' => 'Profítis Ilías'
],[
'state_id' => 1470,
'name' => 'Pánormos'
],[
'state_id' => 1470,
'name' => 'Pérama'
],[
'state_id' => 1470,
'name' => 'Pýrgos'
],[
'state_id' => 1470,
'name' => 'Rethymno'
],[
'state_id' => 1470,
'name' => 'Schísma Eloúndas'
],[
'state_id' => 1470,
'name' => 'Sitia'
],[
'state_id' => 1470,
'name' => 'Skalánion'
],[
'state_id' => 1470,
'name' => 'Soúda'
],[
'state_id' => 1470,
'name' => 'Stalís'
],[
'state_id' => 1470,
'name' => 'Sísion'
],[
'state_id' => 1470,
'name' => 'Thrapsanón'
],[
'state_id' => 1470,
'name' => 'Tsikalariá'
],[
'state_id' => 1470,
'name' => 'Tympáki'
],[
'state_id' => 1470,
'name' => 'Tílisos'
],[
'state_id' => 1470,
'name' => 'Violí Charáki'
],[
'state_id' => 1470,
'name' => 'Vrýses'
],[
'state_id' => 1470,
'name' => 'Zarós'
],[
'state_id' => 1470,
'name' => 'Zonianá'
],[
'state_id' => 1470,
'name' => 'Ágioi Déka'
],[
'state_id' => 1470,
'name' => 'Ágios Nikólaos'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
