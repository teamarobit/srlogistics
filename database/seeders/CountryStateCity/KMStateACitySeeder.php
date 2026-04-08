<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KMStateACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 853,
'name' => 'Adda-Douéni'
],[
'state_id' => 853,
'name' => 'Antsahé'
],[
'state_id' => 853,
'name' => 'Assimpao'
],[
'state_id' => 853,
'name' => 'Bambao'
],[
'state_id' => 853,
'name' => 'Bandajou'
],[
'state_id' => 853,
'name' => 'Barakani'
],[
'state_id' => 853,
'name' => 'Bimbini'
],[
'state_id' => 853,
'name' => 'Boungouéni'
],[
'state_id' => 853,
'name' => 'Chandra'
],[
'state_id' => 853,
'name' => 'Chironkamba'
],[
'state_id' => 853,
'name' => 'Chitrouni'
],[
'state_id' => 853,
'name' => 'Daji'
],[
'state_id' => 853,
'name' => 'Domoni'
],[
'state_id' => 853,
'name' => 'Dziani'
],[
'state_id' => 853,
'name' => 'Hajoho'
],[
'state_id' => 853,
'name' => 'Harembo'
],[
'state_id' => 853,
'name' => 'Kangani'
],[
'state_id' => 853,
'name' => 'Kavani'
],[
'state_id' => 853,
'name' => 'Koki'
],[
'state_id' => 853,
'name' => 'Koni-Djodjo'
],[
'state_id' => 853,
'name' => 'Koni-Ngani'
],[
'state_id' => 853,
'name' => 'Kyo'
],[
'state_id' => 853,
'name' => 'Limbi'
],[
'state_id' => 853,
'name' => 'Lingoni'
],[
'state_id' => 853,
'name' => 'Magnassini-Nindri'
],[
'state_id' => 853,
'name' => 'Maraharé'
],[
'state_id' => 853,
'name' => 'Mirontsi'
],[
'state_id' => 853,
'name' => 'Mjamaoué'
],[
'state_id' => 853,
'name' => 'Mjimandra'
],[
'state_id' => 853,
'name' => 'Moutsamoudou'
],[
'state_id' => 853,
'name' => 'Moya'
],[
'state_id' => 853,
'name' => 'Mramani'
],[
'state_id' => 853,
'name' => 'Mrémani'
],[
'state_id' => 853,
'name' => 'Ongoni'
],[
'state_id' => 853,
'name' => 'Ouani'
],[
'state_id' => 853,
'name' => 'Ouzini'
],[
'state_id' => 853,
'name' => 'Pajé'
],[
'state_id' => 853,
'name' => 'Patsi'
],[
'state_id' => 853,
'name' => 'Sima'
],[
'state_id' => 853,
'name' => 'Tsimbeo'
],[
'state_id' => 853,
'name' => 'Vouani'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
