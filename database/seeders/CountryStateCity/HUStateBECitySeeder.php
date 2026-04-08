<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HUStateBECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1661,
'name' => 'Battonya'
],[
'state_id' => 1661,
'name' => 'Bucsa'
],[
'state_id' => 1661,
'name' => 'Békés'
],[
'state_id' => 1661,
'name' => 'Békéscsaba'
],[
'state_id' => 1661,
'name' => 'Békéscsabai Járás'
],[
'state_id' => 1661,
'name' => 'Békési Járás'
],[
'state_id' => 1661,
'name' => 'Békésszentandrás'
],[
'state_id' => 1661,
'name' => 'Békéssámson'
],[
'state_id' => 1661,
'name' => 'Csanádapáca'
],[
'state_id' => 1661,
'name' => 'Csorvás'
],[
'state_id' => 1661,
'name' => 'Doboz'
],[
'state_id' => 1661,
'name' => 'Dombegyház'
],[
'state_id' => 1661,
'name' => 'Dévaványa'
],[
'state_id' => 1661,
'name' => 'Elek'
],[
'state_id' => 1661,
'name' => 'Füzesgyarmat'
],[
'state_id' => 1661,
'name' => 'Gyomaendrőd'
],[
'state_id' => 1661,
'name' => 'Gyomaendrődi Járás'
],[
'state_id' => 1661,
'name' => 'Gyula'
],[
'state_id' => 1661,
'name' => 'Gyulai Járás'
],[
'state_id' => 1661,
'name' => 'Gádoros'
],[
'state_id' => 1661,
'name' => 'Kaszaper'
],[
'state_id' => 1661,
'name' => 'Kevermes'
],[
'state_id' => 1661,
'name' => 'Kondoros'
],[
'state_id' => 1661,
'name' => 'Kunágota'
],[
'state_id' => 1661,
'name' => 'Kétegyháza'
],[
'state_id' => 1661,
'name' => 'Körösladány'
],[
'state_id' => 1661,
'name' => 'Köröstarcsa'
],[
'state_id' => 1661,
'name' => 'Lőkösháza'
],[
'state_id' => 1661,
'name' => 'Magyarbánhegyes'
],[
'state_id' => 1661,
'name' => 'Medgyesegyháza'
],[
'state_id' => 1661,
'name' => 'Mezőberény'
],[
'state_id' => 1661,
'name' => 'Mezőhegyes'
],[
'state_id' => 1661,
'name' => 'Mezőkovácsháza'
],[
'state_id' => 1661,
'name' => 'Mezőkovácsházai Járás'
],[
'state_id' => 1661,
'name' => 'Méhkerék'
],[
'state_id' => 1661,
'name' => 'Nagyszénás'
],[
'state_id' => 1661,
'name' => 'Okány'
],[
'state_id' => 1661,
'name' => 'Orosháza'
],[
'state_id' => 1661,
'name' => 'Orosházi Járás'
],[
'state_id' => 1661,
'name' => 'Pusztaföldvár'
],[
'state_id' => 1661,
'name' => 'Sarkad'
],[
'state_id' => 1661,
'name' => 'Sarkadi Járás'
],[
'state_id' => 1661,
'name' => 'Szabadkígyós'
],[
'state_id' => 1661,
'name' => 'Szarvas'
],[
'state_id' => 1661,
'name' => 'Szarvasi Járás'
],[
'state_id' => 1661,
'name' => 'Szeghalmi Járás'
],[
'state_id' => 1661,
'name' => 'Szeghalom'
],[
'state_id' => 1661,
'name' => 'Tótkomlós'
],[
'state_id' => 1661,
'name' => 'Vésztő'
],[
'state_id' => 1661,
'name' => 'Újkígyós'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
