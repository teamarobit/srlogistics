<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HRState18CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 950,
'name' => 'Bale'
],[
'state_id' => 950,
'name' => 'Bale-Valle'
],[
'state_id' => 950,
'name' => 'Brtonigla'
],[
'state_id' => 950,
'name' => 'Brtonigla-Verteneglio'
],[
'state_id' => 950,
'name' => 'Buje'
],[
'state_id' => 950,
'name' => 'Buje-Buie'
],[
'state_id' => 950,
'name' => 'Buzet'
],[
'state_id' => 950,
'name' => 'Fažana'
],[
'state_id' => 950,
'name' => 'Fažana-Fasana'
],[
'state_id' => 950,
'name' => 'Funtana'
],[
'state_id' => 950,
'name' => 'Funtana-Fontane'
],[
'state_id' => 950,
'name' => 'Galižana'
],[
'state_id' => 950,
'name' => 'Grad Buzet'
],[
'state_id' => 950,
'name' => 'Grad Labin'
],[
'state_id' => 950,
'name' => 'Grad Pazin'
],[
'state_id' => 950,
'name' => 'Grožnjan'
],[
'state_id' => 950,
'name' => 'Grožnjan-Grisignana'
],[
'state_id' => 950,
'name' => 'Kanfanar'
],[
'state_id' => 950,
'name' => 'Karojba'
],[
'state_id' => 950,
'name' => 'Kaštelir-Labinci'
],[
'state_id' => 950,
'name' => 'Labin'
],[
'state_id' => 950,
'name' => 'Ližnjan'
],[
'state_id' => 950,
'name' => 'Ližnjan-Lisignano'
],[
'state_id' => 950,
'name' => 'Lupoglav'
],[
'state_id' => 950,
'name' => 'Marčana'
],[
'state_id' => 950,
'name' => 'Medulin'
],[
'state_id' => 950,
'name' => 'Motovun'
],[
'state_id' => 950,
'name' => 'Motovun-Montona'
],[
'state_id' => 950,
'name' => 'Novigrad'
],[
'state_id' => 950,
'name' => 'Novigrad-Cittanova'
],[
'state_id' => 950,
'name' => 'Oprtalj-Portole'
],[
'state_id' => 950,
'name' => 'Općina Lanišće'
],[
'state_id' => 950,
'name' => 'Pazin'
],[
'state_id' => 950,
'name' => 'Poreč'
],[
'state_id' => 950,
'name' => 'Poreč-Parenzo'
],[
'state_id' => 950,
'name' => 'Pula'
],[
'state_id' => 950,
'name' => 'Pula-Pola'
],[
'state_id' => 950,
'name' => 'Rabac'
],[
'state_id' => 950,
'name' => 'Raša'
],[
'state_id' => 950,
'name' => 'Rovinj'
],[
'state_id' => 950,
'name' => 'Rovinj-Rovigno'
],[
'state_id' => 950,
'name' => 'Sveta Nedelja'
],[
'state_id' => 950,
'name' => 'Sveti Lovreč'
],[
'state_id' => 950,
'name' => 'Tar'
],[
'state_id' => 950,
'name' => 'Tar-Vabriga-Torre Abrega'
],[
'state_id' => 950,
'name' => 'Umag'
],[
'state_id' => 950,
'name' => 'Umag-Umago'
],[
'state_id' => 950,
'name' => 'Valbandon'
],[
'state_id' => 950,
'name' => 'Vinež'
],[
'state_id' => 950,
'name' => 'Višnjan-Visignano'
],[
'state_id' => 950,
'name' => 'Vižinada-Visinada'
],[
'state_id' => 950,
'name' => 'Vodnjan'
],[
'state_id' => 950,
'name' => 'Vodnjan-Dignano'
],[
'state_id' => 950,
'name' => 'Vrsar'
],[
'state_id' => 950,
'name' => 'Vrsar-Orsera'
],[
'state_id' => 950,
'name' => 'Žminj'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
