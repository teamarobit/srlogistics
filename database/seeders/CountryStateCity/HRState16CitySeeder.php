<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HRState16CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 948,
'name' => 'Andrijaševci'
],[
'state_id' => 948,
'name' => 'Babina Greda'
],[
'state_id' => 948,
'name' => 'Bobota'
],[
'state_id' => 948,
'name' => 'Bogdanovci'
],[
'state_id' => 948,
'name' => 'Borovo'
],[
'state_id' => 948,
'name' => 'Borovo Selo'
],[
'state_id' => 948,
'name' => 'Bošnjaci'
],[
'state_id' => 948,
'name' => 'Bršadin'
],[
'state_id' => 948,
'name' => 'Cerić'
],[
'state_id' => 948,
'name' => 'Cerna'
],[
'state_id' => 948,
'name' => 'Drenovci'
],[
'state_id' => 948,
'name' => 'Grad Vinkovci'
],[
'state_id' => 948,
'name' => 'Grad Vukovar'
],[
'state_id' => 948,
'name' => 'Grad Županja'
],[
'state_id' => 948,
'name' => 'Gradište'
],[
'state_id' => 948,
'name' => 'Gunja'
],[
'state_id' => 948,
'name' => 'Ilok'
],[
'state_id' => 948,
'name' => 'Ivankovo'
],[
'state_id' => 948,
'name' => 'Jarmina'
],[
'state_id' => 948,
'name' => 'Komletinci'
],[
'state_id' => 948,
'name' => 'Lovas'
],[
'state_id' => 948,
'name' => 'Markušica'
],[
'state_id' => 948,
'name' => 'Mirkovci'
],[
'state_id' => 948,
'name' => 'Negoslavci'
],[
'state_id' => 948,
'name' => 'Nijemci'
],[
'state_id' => 948,
'name' => 'Nuštar'
],[
'state_id' => 948,
'name' => 'Otok'
],[
'state_id' => 948,
'name' => 'Privlaka'
],[
'state_id' => 948,
'name' => 'Retkovci'
],[
'state_id' => 948,
'name' => 'Rokovci'
],[
'state_id' => 948,
'name' => 'Soljani'
],[
'state_id' => 948,
'name' => 'Stari Jankovci'
],[
'state_id' => 948,
'name' => 'Tordinci'
],[
'state_id' => 948,
'name' => 'Tovarnik'
],[
'state_id' => 948,
'name' => 'Trpinja'
],[
'state_id' => 948,
'name' => 'Vinkovci'
],[
'state_id' => 948,
'name' => 'Vođinci'
],[
'state_id' => 948,
'name' => 'Vrbanja'
],[
'state_id' => 948,
'name' => 'Vukovar'
],[
'state_id' => 948,
'name' => 'Štitar'
],[
'state_id' => 948,
'name' => 'Županja'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
