<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HUStateBZCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1659,
'name' => 'Abaújszántó'
],[
'state_id' => 1659,
'name' => 'Alsózsolca'
],[
'state_id' => 1659,
'name' => 'Arló'
],[
'state_id' => 1659,
'name' => 'Arnót'
],[
'state_id' => 1659,
'name' => 'Aszaló'
],[
'state_id' => 1659,
'name' => 'Bekecs'
],[
'state_id' => 1659,
'name' => 'Bogács'
],[
'state_id' => 1659,
'name' => 'Boldva'
],[
'state_id' => 1659,
'name' => 'Borsodnádasd'
],[
'state_id' => 1659,
'name' => 'Bőcs'
],[
'state_id' => 1659,
'name' => 'Cigánd'
],[
'state_id' => 1659,
'name' => 'Cigándi Járás'
],[
'state_id' => 1659,
'name' => 'Edelény'
],[
'state_id' => 1659,
'name' => 'Edelényi Járás'
],[
'state_id' => 1659,
'name' => 'Emőd'
],[
'state_id' => 1659,
'name' => 'Encs'
],[
'state_id' => 1659,
'name' => 'Encsi Járás'
],[
'state_id' => 1659,
'name' => 'Farkaslyuk'
],[
'state_id' => 1659,
'name' => 'Felsőzsolca'
],[
'state_id' => 1659,
'name' => 'Gesztely'
],[
'state_id' => 1659,
'name' => 'Gönc'
],[
'state_id' => 1659,
'name' => 'Gönci Járás'
],[
'state_id' => 1659,
'name' => 'Halmaj'
],[
'state_id' => 1659,
'name' => 'Harsány'
],[
'state_id' => 1659,
'name' => 'Hejőbába'
],[
'state_id' => 1659,
'name' => 'Hernádnémeti'
],[
'state_id' => 1659,
'name' => 'Izsófalva'
],[
'state_id' => 1659,
'name' => 'Járdánháza'
],[
'state_id' => 1659,
'name' => 'Karcsa'
],[
'state_id' => 1659,
'name' => 'Kazincbarcika'
],[
'state_id' => 1659,
'name' => 'Kazincbarcikai Járás'
],[
'state_id' => 1659,
'name' => 'Megyaszó'
],[
'state_id' => 1659,
'name' => 'Mezőcsát'
],[
'state_id' => 1659,
'name' => 'Mezőcsáti Járás'
],[
'state_id' => 1659,
'name' => 'Mezőkeresztes'
],[
'state_id' => 1659,
'name' => 'Mezőkövesd'
],[
'state_id' => 1659,
'name' => 'Mezőkövesdi Járás'
],[
'state_id' => 1659,
'name' => 'Mezőzombor'
],[
'state_id' => 1659,
'name' => 'Miskolc'
],[
'state_id' => 1659,
'name' => 'Miskolci Járás'
],[
'state_id' => 1659,
'name' => 'Monok'
],[
'state_id' => 1659,
'name' => 'Mád'
],[
'state_id' => 1659,
'name' => 'Mályi'
],[
'state_id' => 1659,
'name' => 'Múcsony'
],[
'state_id' => 1659,
'name' => 'Nyékládháza'
],[
'state_id' => 1659,
'name' => 'Olaszliszka'
],[
'state_id' => 1659,
'name' => 'Onga'
],[
'state_id' => 1659,
'name' => 'Prügy'
],[
'state_id' => 1659,
'name' => 'Putnok'
],[
'state_id' => 1659,
'name' => 'Putnoki Járás'
],[
'state_id' => 1659,
'name' => 'Ricse'
],[
'state_id' => 1659,
'name' => 'Rudabánya'
],[
'state_id' => 1659,
'name' => 'Sajóbábony'
],[
'state_id' => 1659,
'name' => 'Sajókaza'
],[
'state_id' => 1659,
'name' => 'Sajólád'
],[
'state_id' => 1659,
'name' => 'Sajószentpéter'
],[
'state_id' => 1659,
'name' => 'Sajószöged'
],[
'state_id' => 1659,
'name' => 'Sajóvámos'
],[
'state_id' => 1659,
'name' => 'Sajóörös'
],[
'state_id' => 1659,
'name' => 'Szendrő'
],[
'state_id' => 1659,
'name' => 'Szentistván'
],[
'state_id' => 1659,
'name' => 'Szerencs'
],[
'state_id' => 1659,
'name' => 'Szerencsi Járás'
],[
'state_id' => 1659,
'name' => 'Szikszó'
],[
'state_id' => 1659,
'name' => 'Szikszói Járás'
],[
'state_id' => 1659,
'name' => 'Szirmabesenyő'
],[
'state_id' => 1659,
'name' => 'Sály'
],[
'state_id' => 1659,
'name' => 'Sárospatak'
],[
'state_id' => 1659,
'name' => 'Sárospataki Járás'
],[
'state_id' => 1659,
'name' => 'Sátoraljaújhely'
],[
'state_id' => 1659,
'name' => 'Sátoraljaújhelyi Járás'
],[
'state_id' => 1659,
'name' => 'Taktaharkány'
],[
'state_id' => 1659,
'name' => 'Taktaszada'
],[
'state_id' => 1659,
'name' => 'Tarcal'
],[
'state_id' => 1659,
'name' => 'Tiszakarád'
],[
'state_id' => 1659,
'name' => 'Tiszakeszi'
],[
'state_id' => 1659,
'name' => 'Tiszalúc'
],[
'state_id' => 1659,
'name' => 'Tiszaújváros'
],[
'state_id' => 1659,
'name' => 'Tiszaújvárosi Járás'
],[
'state_id' => 1659,
'name' => 'Tokaj'
],[
'state_id' => 1659,
'name' => 'Tokaji Járás'
],[
'state_id' => 1659,
'name' => 'Tolcsva'
],[
'state_id' => 1659,
'name' => 'Tállya'
],[
'state_id' => 1659,
'name' => 'Ónod'
],[
'state_id' => 1659,
'name' => 'Ózd'
],[
'state_id' => 1659,
'name' => 'Ózdi Járás'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
