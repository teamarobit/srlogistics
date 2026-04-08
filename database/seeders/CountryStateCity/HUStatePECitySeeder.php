<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HUStatePECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1660,
'name' => 'Abony'
],[
'state_id' => 1660,
'name' => 'Acsa'
],[
'state_id' => 1660,
'name' => 'Albertirsa'
],[
'state_id' => 1660,
'name' => 'Alsónémedi'
],[
'state_id' => 1660,
'name' => 'Aszód'
],[
'state_id' => 1660,
'name' => 'Aszódi Járás'
],[
'state_id' => 1660,
'name' => 'Bag'
],[
'state_id' => 1660,
'name' => 'Biatorbágy'
],[
'state_id' => 1660,
'name' => 'Budakalász'
],[
'state_id' => 1660,
'name' => 'Budakeszi'
],[
'state_id' => 1660,
'name' => 'Budakeszi Járás'
],[
'state_id' => 1660,
'name' => 'Budaörs'
],[
'state_id' => 1660,
'name' => 'Bugyi'
],[
'state_id' => 1660,
'name' => 'Cegléd'
],[
'state_id' => 1660,
'name' => 'Ceglédbercel'
],[
'state_id' => 1660,
'name' => 'Ceglédi Járás'
],[
'state_id' => 1660,
'name' => 'Csemő'
],[
'state_id' => 1660,
'name' => 'Csobánka'
],[
'state_id' => 1660,
'name' => 'Csömör'
],[
'state_id' => 1660,
'name' => 'Dabas'
],[
'state_id' => 1660,
'name' => 'Dabasi Járás'
],[
'state_id' => 1660,
'name' => 'Diósd'
],[
'state_id' => 1660,
'name' => 'Domony'
],[
'state_id' => 1660,
'name' => 'Dunabogdány'
],[
'state_id' => 1660,
'name' => 'Dunaharaszti'
],[
'state_id' => 1660,
'name' => 'Dunakeszi'
],[
'state_id' => 1660,
'name' => 'Dunakeszi Járás'
],[
'state_id' => 1660,
'name' => 'Dunavarsány'
],[
'state_id' => 1660,
'name' => 'Dánszentmiklós'
],[
'state_id' => 1660,
'name' => 'Dány'
],[
'state_id' => 1660,
'name' => 'Délegyháza'
],[
'state_id' => 1660,
'name' => 'Dömsöd'
],[
'state_id' => 1660,
'name' => 'Ecser'
],[
'state_id' => 1660,
'name' => 'Erdőkertes'
],[
'state_id' => 1660,
'name' => 'Farmos'
],[
'state_id' => 1660,
'name' => 'Felsőpakony'
],[
'state_id' => 1660,
'name' => 'Forrópuszta'
],[
'state_id' => 1660,
'name' => 'Fót'
],[
'state_id' => 1660,
'name' => 'Galgahévíz'
],[
'state_id' => 1660,
'name' => 'Galgamácsa'
],[
'state_id' => 1660,
'name' => 'Gomba'
],[
'state_id' => 1660,
'name' => 'Gyál'
],[
'state_id' => 1660,
'name' => 'Gyáli Járás'
],[
'state_id' => 1660,
'name' => 'Gyömrő'
],[
'state_id' => 1660,
'name' => 'Göd'
],[
'state_id' => 1660,
'name' => 'Gödöllő'
],[
'state_id' => 1660,
'name' => 'Gödöllői Járás'
],[
'state_id' => 1660,
'name' => 'Halásztelek'
],[
'state_id' => 1660,
'name' => 'Hernád'
],[
'state_id' => 1660,
'name' => 'Hévízgyörk'
],[
'state_id' => 1660,
'name' => 'Iklad'
],[
'state_id' => 1660,
'name' => 'Inárcs'
],[
'state_id' => 1660,
'name' => 'Isaszeg'
],[
'state_id' => 1660,
'name' => 'Jászkarajenő'
],[
'state_id' => 1660,
'name' => 'Kakucs'
],[
'state_id' => 1660,
'name' => 'Kartal'
],[
'state_id' => 1660,
'name' => 'Kerepes'
],[
'state_id' => 1660,
'name' => 'Kiskunlacháza'
],[
'state_id' => 1660,
'name' => 'Kismaros'
],[
'state_id' => 1660,
'name' => 'Kistarcsa'
],[
'state_id' => 1660,
'name' => 'Kocsér'
],[
'state_id' => 1660,
'name' => 'Kosd'
],[
'state_id' => 1660,
'name' => 'Kóka'
],[
'state_id' => 1660,
'name' => 'Leányfalu'
],[
'state_id' => 1660,
'name' => 'Maglód'
],[
'state_id' => 1660,
'name' => 'Mende'
],[
'state_id' => 1660,
'name' => 'Mogyoród'
],[
'state_id' => 1660,
'name' => 'Monor'
],[
'state_id' => 1660,
'name' => 'Monori Járás'
],[
'state_id' => 1660,
'name' => 'Nagykovácsi'
],[
'state_id' => 1660,
'name' => 'Nagykáta'
],[
'state_id' => 1660,
'name' => 'Nagykátai Járás'
],[
'state_id' => 1660,
'name' => 'Nagykőrös'
],[
'state_id' => 1660,
'name' => 'Nagykőrösi Járás'
],[
'state_id' => 1660,
'name' => 'Nagymaros'
],[
'state_id' => 1660,
'name' => 'Nagytarcsa'
],[
'state_id' => 1660,
'name' => 'Nyáregyháza'
],[
'state_id' => 1660,
'name' => 'Perbál'
],[
'state_id' => 1660,
'name' => 'Pilis'
],[
'state_id' => 1660,
'name' => 'Pilisborosjenő'
],[
'state_id' => 1660,
'name' => 'Piliscsaba'
],[
'state_id' => 1660,
'name' => 'Pilisszentiván'
],[
'state_id' => 1660,
'name' => 'Pilisszentkereszt'
],[
'state_id' => 1660,
'name' => 'Pilisszántó'
],[
'state_id' => 1660,
'name' => 'Pilisvörösvár'
],[
'state_id' => 1660,
'name' => 'Pilisvörösvári Járás'
],[
'state_id' => 1660,
'name' => 'Pomáz'
],[
'state_id' => 1660,
'name' => 'Pánd'
],[
'state_id' => 1660,
'name' => 'Páty'
],[
'state_id' => 1660,
'name' => 'Pécel'
],[
'state_id' => 1660,
'name' => 'Péteri'
],[
'state_id' => 1660,
'name' => 'Ráckeve'
],[
'state_id' => 1660,
'name' => 'Ráckevei Járás'
],[
'state_id' => 1660,
'name' => 'Solymár'
],[
'state_id' => 1660,
'name' => 'Szada'
],[
'state_id' => 1660,
'name' => 'Szentendre'
],[
'state_id' => 1660,
'name' => 'Szentendrei Járás'
],[
'state_id' => 1660,
'name' => 'Szentlőrinckáta'
],[
'state_id' => 1660,
'name' => 'Szentmártonkáta'
],[
'state_id' => 1660,
'name' => 'Szigetcsép'
],[
'state_id' => 1660,
'name' => 'Szigethalom'
],[
'state_id' => 1660,
'name' => 'Szigetszentmiklós'
],[
'state_id' => 1660,
'name' => 'Szigetszentmiklósi Járás'
],[
'state_id' => 1660,
'name' => 'Szigetújfalu'
],[
'state_id' => 1660,
'name' => 'Szob'
],[
'state_id' => 1660,
'name' => 'Szobi Járás'
],[
'state_id' => 1660,
'name' => 'Százhalombatta'
],[
'state_id' => 1660,
'name' => 'Sződ'
],[
'state_id' => 1660,
'name' => 'Sződliget'
],[
'state_id' => 1660,
'name' => 'Sóskút'
],[
'state_id' => 1660,
'name' => 'Sülysáp'
],[
'state_id' => 1660,
'name' => 'Tahitótfalu'
],[
'state_id' => 1660,
'name' => 'Taksony'
],[
'state_id' => 1660,
'name' => 'Telki'
],[
'state_id' => 1660,
'name' => 'Tura'
],[
'state_id' => 1660,
'name' => 'Táborfalva'
],[
'state_id' => 1660,
'name' => 'Tápióbicske'
],[
'state_id' => 1660,
'name' => 'Tápiógyörgye'
],[
'state_id' => 1660,
'name' => 'Tápiószecső'
],[
'state_id' => 1660,
'name' => 'Tápiószele'
],[
'state_id' => 1660,
'name' => 'Tápiószentmárton'
],[
'state_id' => 1660,
'name' => 'Tápiószőlős'
],[
'state_id' => 1660,
'name' => 'Tápióság'
],[
'state_id' => 1660,
'name' => 'Tárnok'
],[
'state_id' => 1660,
'name' => 'Tóalmás'
],[
'state_id' => 1660,
'name' => 'Tököl'
],[
'state_id' => 1660,
'name' => 'Törtel'
],[
'state_id' => 1660,
'name' => 'Törökbálint'
],[
'state_id' => 1660,
'name' => 'Valkó'
],[
'state_id' => 1660,
'name' => 'Vecsés'
],[
'state_id' => 1660,
'name' => 'Vecsési Járás'
],[
'state_id' => 1660,
'name' => 'Veresegyház'
],[
'state_id' => 1660,
'name' => 'Verőce'
],[
'state_id' => 1660,
'name' => 'Visegrád'
],[
'state_id' => 1660,
'name' => 'Vác'
],[
'state_id' => 1660,
'name' => 'Váci Járás'
],[
'state_id' => 1660,
'name' => 'Vácszentlászló'
],[
'state_id' => 1660,
'name' => 'Zsámbok'
],[
'state_id' => 1660,
'name' => 'Zsámbék'
],[
'state_id' => 1660,
'name' => 'Érd'
],[
'state_id' => 1660,
'name' => 'Érdi Járás'
],[
'state_id' => 1660,
'name' => 'Ócsa'
],[
'state_id' => 1660,
'name' => 'Örkény'
],[
'state_id' => 1660,
'name' => 'Újhartyán'
],[
'state_id' => 1660,
'name' => 'Újszilvás'
],[
'state_id' => 1660,
'name' => 'Úri'
],[
'state_id' => 1660,
'name' => 'Üllő'
],[
'state_id' => 1660,
'name' => 'Üröm'
],[
'state_id' => 1660,
'name' => 'Őrbottyán'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
