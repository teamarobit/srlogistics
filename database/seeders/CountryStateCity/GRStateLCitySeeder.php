<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GRStateLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1479,
'name' => 'Adámas'
],[
'state_id' => 1479,
'name' => 'Afántou'
],[
'state_id' => 1479,
'name' => 'Agía Marína'
],[
'state_id' => 1479,
'name' => 'Amorgós'
],[
'state_id' => 1479,
'name' => 'Andros'
],[
'state_id' => 1479,
'name' => 'Antimácheia'
],[
'state_id' => 1479,
'name' => 'Antíparos'
],[
'state_id' => 1479,
'name' => 'Anáfi'
],[
'state_id' => 1479,
'name' => 'Archángelos'
],[
'state_id' => 1479,
'name' => 'Astypálaia'
],[
'state_id' => 1479,
'name' => 'Chálki'
],[
'state_id' => 1479,
'name' => 'Emporeío'
],[
'state_id' => 1479,
'name' => 'Ermoúpolis'
],[
'state_id' => 1479,
'name' => 'Faliraki'
],[
'state_id' => 1479,
'name' => 'Filótion'
],[
'state_id' => 1479,
'name' => 'Firá'
],[
'state_id' => 1479,
'name' => 'Folégandros'
],[
'state_id' => 1479,
'name' => 'Fry'
],[
'state_id' => 1479,
'name' => 'Ialysós'
],[
'state_id' => 1479,
'name' => 'Kardámaina'
],[
'state_id' => 1479,
'name' => 'Karpathos'
],[
'state_id' => 1479,
'name' => 'Kos'
],[
'state_id' => 1479,
'name' => 'Kremastí'
],[
'state_id' => 1479,
'name' => 'Kálymnos'
],[
'state_id' => 1479,
'name' => 'Kéfalos'
],[
'state_id' => 1479,
'name' => 'Kímolos'
],[
'state_id' => 1479,
'name' => 'Kýthnos'
],[
'state_id' => 1479,
'name' => 'Lakkí'
],[
'state_id' => 1479,
'name' => 'Lárdos'
],[
'state_id' => 1479,
'name' => 'Mandráki'
],[
'state_id' => 1479,
'name' => 'Megálo Chorió'
],[
'state_id' => 1479,
'name' => 'Megísti'
],[
'state_id' => 1479,
'name' => 'Mesariá'
],[
'state_id' => 1479,
'name' => 'Mykonos'
],[
'state_id' => 1479,
'name' => 'Mílos'
],[
'state_id' => 1479,
'name' => 'Nomós Kykládon'
],[
'state_id' => 1479,
'name' => 'Náousa'
],[
'state_id' => 1479,
'name' => 'Náxos'
],[
'state_id' => 1479,
'name' => 'Ornós'
],[
'state_id' => 1479,
'name' => 'Oía'
],[
'state_id' => 1479,
'name' => 'Pylí'
],[
'state_id' => 1479,
'name' => 'Pánormos'
],[
'state_id' => 1479,
'name' => 'Páros'
],[
'state_id' => 1479,
'name' => 'Pátmos'
],[
'state_id' => 1479,
'name' => 'Ródos'
],[
'state_id' => 1479,
'name' => 'Skála'
],[
'state_id' => 1479,
'name' => 'Sérifos'
],[
'state_id' => 1479,
'name' => 'Sými'
],[
'state_id' => 1479,
'name' => 'Tínos'
],[
'state_id' => 1479,
'name' => 'Vári'
],[
'state_id' => 1479,
'name' => 'Zipári'
],[
'state_id' => 1479,
'name' => 'Áno Merá'
],[
'state_id' => 1479,
'name' => 'Áno Sýros'
],[
'state_id' => 1479,
'name' => 'Émponas'
],[
'state_id' => 1479,
'name' => 'Íos'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
