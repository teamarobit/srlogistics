<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HUStateFECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1645,
'name' => 'Aba'
],[
'state_id' => 1645,
'name' => 'Adony'
],[
'state_id' => 1645,
'name' => 'Alap'
],[
'state_id' => 1645,
'name' => 'Bakonycsernye'
],[
'state_id' => 1645,
'name' => 'Baracs'
],[
'state_id' => 1645,
'name' => 'Baracska'
],[
'state_id' => 1645,
'name' => 'Bicske'
],[
'state_id' => 1645,
'name' => 'Bicskei Járás'
],[
'state_id' => 1645,
'name' => 'Bodajk'
],[
'state_id' => 1645,
'name' => 'Cece'
],[
'state_id' => 1645,
'name' => 'Csákvár'
],[
'state_id' => 1645,
'name' => 'Dunaújvárosi Járás'
],[
'state_id' => 1645,
'name' => 'Dég'
],[
'state_id' => 1645,
'name' => 'Előszállás'
],[
'state_id' => 1645,
'name' => 'Enying'
],[
'state_id' => 1645,
'name' => 'Enyingi Járás'
],[
'state_id' => 1645,
'name' => 'Ercsi'
],[
'state_id' => 1645,
'name' => 'Etyek'
],[
'state_id' => 1645,
'name' => 'Fehérvárcsurgó'
],[
'state_id' => 1645,
'name' => 'Gárdony'
],[
'state_id' => 1645,
'name' => 'Gárdonyi Járás'
],[
'state_id' => 1645,
'name' => 'Iváncsa'
],[
'state_id' => 1645,
'name' => 'Kincsesbánya'
],[
'state_id' => 1645,
'name' => 'Kisláng'
],[
'state_id' => 1645,
'name' => 'Káloz'
],[
'state_id' => 1645,
'name' => 'Kápolnásnyék'
],[
'state_id' => 1645,
'name' => 'Lajoskomárom'
],[
'state_id' => 1645,
'name' => 'Lepsény'
],[
'state_id' => 1645,
'name' => 'Lovasberény'
],[
'state_id' => 1645,
'name' => 'Martonvásár'
],[
'state_id' => 1645,
'name' => 'Martonvásári Járás'
],[
'state_id' => 1645,
'name' => 'Mezőfalva'
],[
'state_id' => 1645,
'name' => 'Mezőszilas'
],[
'state_id' => 1645,
'name' => 'Mány'
],[
'state_id' => 1645,
'name' => 'Mór'
],[
'state_id' => 1645,
'name' => 'Móri Járás'
],[
'state_id' => 1645,
'name' => 'Perkáta'
],[
'state_id' => 1645,
'name' => 'Polgárdi'
],[
'state_id' => 1645,
'name' => 'Pusztaszabolcs'
],[
'state_id' => 1645,
'name' => 'Pusztavám'
],[
'state_id' => 1645,
'name' => 'Pákozd'
],[
'state_id' => 1645,
'name' => 'Pázmánd'
],[
'state_id' => 1645,
'name' => 'Rácalmás'
],[
'state_id' => 1645,
'name' => 'Ráckeresztúr'
],[
'state_id' => 1645,
'name' => 'Seregélyes'
],[
'state_id' => 1645,
'name' => 'Soponya'
],[
'state_id' => 1645,
'name' => 'Szabadbattyán'
],[
'state_id' => 1645,
'name' => 'Szárliget'
],[
'state_id' => 1645,
'name' => 'Székesfehérvár'
],[
'state_id' => 1645,
'name' => 'Székesfehérvári Járás'
],[
'state_id' => 1645,
'name' => 'Sárbogárd'
],[
'state_id' => 1645,
'name' => 'Sárbogárdi Járás'
],[
'state_id' => 1645,
'name' => 'Sárkeresztúr'
],[
'state_id' => 1645,
'name' => 'Sárosd'
],[
'state_id' => 1645,
'name' => 'Sárszentmihály'
],[
'state_id' => 1645,
'name' => 'Velence'
],[
'state_id' => 1645,
'name' => 'Vál'
],[
'state_id' => 1645,
'name' => 'Zámoly'
],[
'state_id' => 1645,
'name' => 'dunaújváros'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
