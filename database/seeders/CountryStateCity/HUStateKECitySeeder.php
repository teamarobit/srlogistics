<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HUStateKECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1670,
'name' => 'Aka'
],[
'state_id' => 1670,
'name' => 'Almásfüzitő'
],[
'state_id' => 1670,
'name' => 'Bajót'
],[
'state_id' => 1670,
'name' => 'Bakonybánk'
],[
'state_id' => 1670,
'name' => 'Bakonyszombathely'
],[
'state_id' => 1670,
'name' => 'Bakonysárkány'
],[
'state_id' => 1670,
'name' => 'Bana'
],[
'state_id' => 1670,
'name' => 'Bábolna'
],[
'state_id' => 1670,
'name' => 'Bánhida'
],[
'state_id' => 1670,
'name' => 'Bársonyos'
],[
'state_id' => 1670,
'name' => 'Csatka'
],[
'state_id' => 1670,
'name' => 'Csolnok'
],[
'state_id' => 1670,
'name' => 'Császár'
],[
'state_id' => 1670,
'name' => 'Csém'
],[
'state_id' => 1670,
'name' => 'Csép'
],[
'state_id' => 1670,
'name' => 'Dad'
],[
'state_id' => 1670,
'name' => 'Dorog'
],[
'state_id' => 1670,
'name' => 'Dunaalmás'
],[
'state_id' => 1670,
'name' => 'Dunaszentmiklós'
],[
'state_id' => 1670,
'name' => 'Dág'
],[
'state_id' => 1670,
'name' => 'Dömös'
],[
'state_id' => 1670,
'name' => 'Epöl'
],[
'state_id' => 1670,
'name' => 'Esztergom'
],[
'state_id' => 1670,
'name' => 'Ete'
],[
'state_id' => 1670,
'name' => 'Gyermely'
],[
'state_id' => 1670,
'name' => 'Héreg'
],[
'state_id' => 1670,
'name' => 'Kecskéd'
],[
'state_id' => 1670,
'name' => 'Kerékteleki'
],[
'state_id' => 1670,
'name' => 'Kesztölc'
],[
'state_id' => 1670,
'name' => 'Kisbér'
],[
'state_id' => 1670,
'name' => 'Kisigmánd'
],[
'state_id' => 1670,
'name' => 'Kocs'
],[
'state_id' => 1670,
'name' => 'Komárom'
],[
'state_id' => 1670,
'name' => 'Kömlőd'
],[
'state_id' => 1670,
'name' => 'Környe'
],[
'state_id' => 1670,
'name' => 'Leányvár'
],[
'state_id' => 1670,
'name' => 'Lábatlan'
],[
'state_id' => 1670,
'name' => 'Mocsa'
],[
'state_id' => 1670,
'name' => 'Mogyorósbánya'
],[
'state_id' => 1670,
'name' => 'Máriahalom'
],[
'state_id' => 1670,
'name' => 'Nagyigmánd'
],[
'state_id' => 1670,
'name' => 'Nagysáp'
],[
'state_id' => 1670,
'name' => 'Naszály'
],[
'state_id' => 1670,
'name' => 'Neszmély'
],[
'state_id' => 1670,
'name' => 'Nyergesújfalu'
],[
'state_id' => 1670,
'name' => 'Oroszlány'
],[
'state_id' => 1670,
'name' => 'Piliscsév'
],[
'state_id' => 1670,
'name' => 'Pilismarót'
],[
'state_id' => 1670,
'name' => 'Réde'
],[
'state_id' => 1670,
'name' => 'Szomor'
],[
'state_id' => 1670,
'name' => 'Szomód'
],[
'state_id' => 1670,
'name' => 'Szákszend'
],[
'state_id' => 1670,
'name' => 'Szőny'
],[
'state_id' => 1670,
'name' => 'Sárisáp'
],[
'state_id' => 1670,
'name' => 'Súr'
],[
'state_id' => 1670,
'name' => 'Süttő'
],[
'state_id' => 1670,
'name' => 'Tardos'
],[
'state_id' => 1670,
'name' => 'Tarján'
],[
'state_id' => 1670,
'name' => 'Tatabánya'
],[
'state_id' => 1670,
'name' => 'Tokodaltáró'
],[
'state_id' => 1670,
'name' => 'Tárkány'
],[
'state_id' => 1670,
'name' => 'Várgesztes'
],[
'state_id' => 1670,
'name' => 'Vérteskethely'
],[
'state_id' => 1670,
'name' => 'Vértessomló'
],[
'state_id' => 1670,
'name' => 'Vértesszőlős'
],[
'state_id' => 1670,
'name' => 'Vértestolna'
],[
'state_id' => 1670,
'name' => 'Ács'
],[
'state_id' => 1670,
'name' => 'Ászár'
],[
'state_id' => 1670,
'name' => 'Úny'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
