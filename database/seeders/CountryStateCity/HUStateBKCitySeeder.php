<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HUStateBKCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1649,
'name' => 'Akasztó'
],[
'state_id' => 1649,
'name' => 'Apostag'
],[
'state_id' => 1649,
'name' => 'Baja'
],[
'state_id' => 1649,
'name' => 'Bajai Járás'
],[
'state_id' => 1649,
'name' => 'Ballószög'
],[
'state_id' => 1649,
'name' => 'Bugac'
],[
'state_id' => 1649,
'name' => 'Bácsalmás'
],[
'state_id' => 1649,
'name' => 'Bácsalmási Járás'
],[
'state_id' => 1649,
'name' => 'Bácsbokod'
],[
'state_id' => 1649,
'name' => 'Bátya'
],[
'state_id' => 1649,
'name' => 'Csengőd'
],[
'state_id' => 1649,
'name' => 'Császártöltés'
],[
'state_id' => 1649,
'name' => 'Csávoly'
],[
'state_id' => 1649,
'name' => 'Dunapataj'
],[
'state_id' => 1649,
'name' => 'Dunavecse'
],[
'state_id' => 1649,
'name' => 'Dusnok'
],[
'state_id' => 1649,
'name' => 'Dávod'
],[
'state_id' => 1649,
'name' => 'Felsőszentiván'
],[
'state_id' => 1649,
'name' => 'Fülöpjakab'
],[
'state_id' => 1649,
'name' => 'Fülöpszállás'
],[
'state_id' => 1649,
'name' => 'Gara'
],[
'state_id' => 1649,
'name' => 'Hajós'
],[
'state_id' => 1649,
'name' => 'Harta'
],[
'state_id' => 1649,
'name' => 'Helvécia'
],[
'state_id' => 1649,
'name' => 'Hercegszántó'
],[
'state_id' => 1649,
'name' => 'Izsák'
],[
'state_id' => 1649,
'name' => 'Jánoshalma'
],[
'state_id' => 1649,
'name' => 'Jánoshalmai Járás'
],[
'state_id' => 1649,
'name' => 'Jászszentlászló'
],[
'state_id' => 1649,
'name' => 'Kalocsa'
],[
'state_id' => 1649,
'name' => 'Kalocsai Járás'
],[
'state_id' => 1649,
'name' => 'Katymár'
],[
'state_id' => 1649,
'name' => 'Kecel'
],[
'state_id' => 1649,
'name' => 'Kecskemét'
],[
'state_id' => 1649,
'name' => 'Kecskeméti Járás'
],[
'state_id' => 1649,
'name' => 'Kelebia'
],[
'state_id' => 1649,
'name' => 'Kerekegyháza'
],[
'state_id' => 1649,
'name' => 'Kiskunfélegyháza'
],[
'state_id' => 1649,
'name' => 'Kiskunfélegyházi Járás'
],[
'state_id' => 1649,
'name' => 'Kiskunhalas'
],[
'state_id' => 1649,
'name' => 'Kiskunhalasi Járás'
],[
'state_id' => 1649,
'name' => 'Kiskunmajsa'
],[
'state_id' => 1649,
'name' => 'Kiskunmajsai Járás'
],[
'state_id' => 1649,
'name' => 'Kiskőrös'
],[
'state_id' => 1649,
'name' => 'Kiskőrösi Járás'
],[
'state_id' => 1649,
'name' => 'Kisszállás'
],[
'state_id' => 1649,
'name' => 'Kunfehértó'
],[
'state_id' => 1649,
'name' => 'Kunszentmiklós'
],[
'state_id' => 1649,
'name' => 'Kunszentmiklósi Járás'
],[
'state_id' => 1649,
'name' => 'Lajosmizse'
],[
'state_id' => 1649,
'name' => 'Lakitelek'
],[
'state_id' => 1649,
'name' => 'Madaras'
],[
'state_id' => 1649,
'name' => 'Mélykút'
],[
'state_id' => 1649,
'name' => 'Nagybaracska'
],[
'state_id' => 1649,
'name' => 'Nemesnádudvar'
],[
'state_id' => 1649,
'name' => 'Nyárlőrinc'
],[
'state_id' => 1649,
'name' => 'Orgovány'
],[
'state_id' => 1649,
'name' => 'Pálmonostora'
],[
'state_id' => 1649,
'name' => 'Solt'
],[
'state_id' => 1649,
'name' => 'Soltvadkert'
],[
'state_id' => 1649,
'name' => 'Szabadszállás'
],[
'state_id' => 1649,
'name' => 'Szalkszentmárton'
],[
'state_id' => 1649,
'name' => 'Szank'
],[
'state_id' => 1649,
'name' => 'Szentkirály'
],[
'state_id' => 1649,
'name' => 'Sükösd'
],[
'state_id' => 1649,
'name' => 'Tass'
],[
'state_id' => 1649,
'name' => 'Tiszaalpár'
],[
'state_id' => 1649,
'name' => 'Tiszakécske'
],[
'state_id' => 1649,
'name' => 'Tiszakécskei Járás'
],[
'state_id' => 1649,
'name' => 'Tompa'
],[
'state_id' => 1649,
'name' => 'Tázlár'
],[
'state_id' => 1649,
'name' => 'Vaskút'
],[
'state_id' => 1649,
'name' => 'Városföld'
],[
'state_id' => 1649,
'name' => 'Ágasegyháza'
],[
'state_id' => 1649,
'name' => 'Érsekcsanád'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
