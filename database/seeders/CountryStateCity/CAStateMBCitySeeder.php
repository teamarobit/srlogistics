<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CAStateMBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 694,
'name' => 'Altona'
],[
'state_id' => 694,
'name' => 'Beausejour'
],[
'state_id' => 694,
'name' => 'Boissevain'
],[
'state_id' => 694,
'name' => 'Brandon'
],[
'state_id' => 694,
'name' => 'Carberry'
],[
'state_id' => 694,
'name' => 'Carman'
],[
'state_id' => 694,
'name' => 'Cross Lake 19A'
],[
'state_id' => 694,
'name' => 'Dauphin'
],[
'state_id' => 694,
'name' => 'De Salaberry'
],[
'state_id' => 694,
'name' => 'Deloraine'
],[
'state_id' => 694,
'name' => 'Flin Flon'
],[
'state_id' => 694,
'name' => 'Gimli'
],[
'state_id' => 694,
'name' => 'Grunthal'
],[
'state_id' => 694,
'name' => 'Headingley'
],[
'state_id' => 694,
'name' => 'Ile des Chênes'
],[
'state_id' => 694,
'name' => 'Killarney'
],[
'state_id' => 694,
'name' => 'La Broquerie'
],[
'state_id' => 694,
'name' => 'Lac du Bonnet'
],[
'state_id' => 694,
'name' => 'Landmark'
],[
'state_id' => 694,
'name' => 'Lorette'
],[
'state_id' => 694,
'name' => 'Melita'
],[
'state_id' => 694,
'name' => 'Minnedosa'
],[
'state_id' => 694,
'name' => 'Moose Lake'
],[
'state_id' => 694,
'name' => 'Morden'
],[
'state_id' => 694,
'name' => 'Morris'
],[
'state_id' => 694,
'name' => 'Neepawa'
],[
'state_id' => 694,
'name' => 'Niverville'
],[
'state_id' => 694,
'name' => 'Portage la Prairie'
],[
'state_id' => 694,
'name' => 'Rivers'
],[
'state_id' => 694,
'name' => 'Roblin'
],[
'state_id' => 694,
'name' => 'Selkirk'
],[
'state_id' => 694,
'name' => 'Shilo'
],[
'state_id' => 694,
'name' => 'Souris'
],[
'state_id' => 694,
'name' => 'St. Adolphe'
],[
'state_id' => 694,
'name' => 'Steinbach'
],[
'state_id' => 694,
'name' => 'Stonewall'
],[
'state_id' => 694,
'name' => 'Swan River'
],[
'state_id' => 694,
'name' => 'The Pas'
],[
'state_id' => 694,
'name' => 'Thompson'
],[
'state_id' => 694,
'name' => 'Virden'
],[
'state_id' => 694,
'name' => 'West St. Paul'
],[
'state_id' => 694,
'name' => 'Winkler'
],[
'state_id' => 694,
'name' => 'Winnipeg'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
