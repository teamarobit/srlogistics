<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HUStateSZCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1646,
'name' => 'Ajak'
],[
'state_id' => 1646,
'name' => 'Anarcs'
],[
'state_id' => 1646,
'name' => 'Apagy'
],[
'state_id' => 1646,
'name' => 'Aranyosapáti'
],[
'state_id' => 1646,
'name' => 'Baktalórántháza'
],[
'state_id' => 1646,
'name' => 'Baktalórántházai Járás'
],[
'state_id' => 1646,
'name' => 'Balkány'
],[
'state_id' => 1646,
'name' => 'Buj'
],[
'state_id' => 1646,
'name' => 'Bököny'
],[
'state_id' => 1646,
'name' => 'Csenger'
],[
'state_id' => 1646,
'name' => 'Csengeri Járás'
],[
'state_id' => 1646,
'name' => 'Demecser'
],[
'state_id' => 1646,
'name' => 'Dombrád'
],[
'state_id' => 1646,
'name' => 'Döge'
],[
'state_id' => 1646,
'name' => 'Encsencs'
],[
'state_id' => 1646,
'name' => 'Fehérgyarmat'
],[
'state_id' => 1646,
'name' => 'Fehérgyarmati Járás'
],[
'state_id' => 1646,
'name' => 'Fényeslitke'
],[
'state_id' => 1646,
'name' => 'Gyulaháza'
],[
'state_id' => 1646,
'name' => 'Gégény'
],[
'state_id' => 1646,
'name' => 'Hodász'
],[
'state_id' => 1646,
'name' => 'Ibrány'
],[
'state_id' => 1646,
'name' => 'Ibrányi Járás'
],[
'state_id' => 1646,
'name' => 'Kemecse'
],[
'state_id' => 1646,
'name' => 'Kemecsei Járás'
],[
'state_id' => 1646,
'name' => 'Kisléta'
],[
'state_id' => 1646,
'name' => 'Kisvárda'
],[
'state_id' => 1646,
'name' => 'Kisvárdai Járás'
],[
'state_id' => 1646,
'name' => 'Kocsord'
],[
'state_id' => 1646,
'name' => 'Kállósemjén'
],[
'state_id' => 1646,
'name' => 'Kálmánháza'
],[
'state_id' => 1646,
'name' => 'Kántorjánosi'
],[
'state_id' => 1646,
'name' => 'Kék'
],[
'state_id' => 1646,
'name' => 'Kótaj'
],[
'state_id' => 1646,
'name' => 'Levelek'
],[
'state_id' => 1646,
'name' => 'Mándok'
],[
'state_id' => 1646,
'name' => 'Máriapócs'
],[
'state_id' => 1646,
'name' => 'Mátészalka'
],[
'state_id' => 1646,
'name' => 'Mátészalkai Járás'
],[
'state_id' => 1646,
'name' => 'Mérk'
],[
'state_id' => 1646,
'name' => 'Nagycserkesz'
],[
'state_id' => 1646,
'name' => 'Nagydobos'
],[
'state_id' => 1646,
'name' => 'Nagyecsed'
],[
'state_id' => 1646,
'name' => 'Nagyhalász'
],[
'state_id' => 1646,
'name' => 'Nagykálló'
],[
'state_id' => 1646,
'name' => 'Nagykállói Járás'
],[
'state_id' => 1646,
'name' => 'Napkor'
],[
'state_id' => 1646,
'name' => 'Nyírbogdány'
],[
'state_id' => 1646,
'name' => 'Nyírbogát'
],[
'state_id' => 1646,
'name' => 'Nyírbátor'
],[
'state_id' => 1646,
'name' => 'Nyírbátori Járás'
],[
'state_id' => 1646,
'name' => 'Nyírbéltek'
],[
'state_id' => 1646,
'name' => 'Nyírcsaholy'
],[
'state_id' => 1646,
'name' => 'Nyíregyháza'
],[
'state_id' => 1646,
'name' => 'Nyíregyházi Járás'
],[
'state_id' => 1646,
'name' => 'Nyírgyulaj'
],[
'state_id' => 1646,
'name' => 'Nyírkarász'
],[
'state_id' => 1646,
'name' => 'Nyírlugos'
],[
'state_id' => 1646,
'name' => 'Nyírmada'
],[
'state_id' => 1646,
'name' => 'Nyírmeggyes'
],[
'state_id' => 1646,
'name' => 'Nyírmihálydi'
],[
'state_id' => 1646,
'name' => 'Nyírpazony'
],[
'state_id' => 1646,
'name' => 'Nyírtass'
],[
'state_id' => 1646,
'name' => 'Nyírtelek'
],[
'state_id' => 1646,
'name' => 'Nyírvasvári'
],[
'state_id' => 1646,
'name' => 'Petneháza'
],[
'state_id' => 1646,
'name' => 'Porcsalma'
],[
'state_id' => 1646,
'name' => 'Pátroha'
],[
'state_id' => 1646,
'name' => 'Rakamaz'
],[
'state_id' => 1646,
'name' => 'Szakoly'
],[
'state_id' => 1646,
'name' => 'Szamosszeg'
],[
'state_id' => 1646,
'name' => 'Tarpa'
],[
'state_id' => 1646,
'name' => 'Tiszabercel'
],[
'state_id' => 1646,
'name' => 'Tiszabezdéd'
],[
'state_id' => 1646,
'name' => 'Tiszadada'
],[
'state_id' => 1646,
'name' => 'Tiszadob'
],[
'state_id' => 1646,
'name' => 'Tiszaeszlár'
],[
'state_id' => 1646,
'name' => 'Tiszalök'
],[
'state_id' => 1646,
'name' => 'Tiszanagyfalu'
],[
'state_id' => 1646,
'name' => 'Tiszavasvári'
],[
'state_id' => 1646,
'name' => 'Tiszavasvári Járás'
],[
'state_id' => 1646,
'name' => 'Tornyospálca'
],[
'state_id' => 1646,
'name' => 'Tunyogmatolcs'
],[
'state_id' => 1646,
'name' => 'Tuzsér'
],[
'state_id' => 1646,
'name' => 'Tyukod'
],[
'state_id' => 1646,
'name' => 'Vaja'
],[
'state_id' => 1646,
'name' => 'Vásárosnamény'
],[
'state_id' => 1646,
'name' => 'Vásárosnaményi Járás'
],[
'state_id' => 1646,
'name' => 'Záhony'
],[
'state_id' => 1646,
'name' => 'Záhonyi Járás'
],[
'state_id' => 1646,
'name' => 'Ófehértó'
],[
'state_id' => 1646,
'name' => 'Ópályi'
],[
'state_id' => 1646,
'name' => 'Ököritófülpös'
],[
'state_id' => 1646,
'name' => 'Újfehértó'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
