<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HUStateCSCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1632,
'name' => 'Algyő'
],[
'state_id' => 1632,
'name' => 'Apátfalva'
],[
'state_id' => 1632,
'name' => 'Baks'
],[
'state_id' => 1632,
'name' => 'Balástya'
],[
'state_id' => 1632,
'name' => 'Bordány'
],[
'state_id' => 1632,
'name' => 'Csanytelek'
],[
'state_id' => 1632,
'name' => 'Csanádpalota'
],[
'state_id' => 1632,
'name' => 'Csengele'
],[
'state_id' => 1632,
'name' => 'Csongrád'
],[
'state_id' => 1632,
'name' => 'Csongrádi Járás'
],[
'state_id' => 1632,
'name' => 'Deszk'
],[
'state_id' => 1632,
'name' => 'Domaszék'
],[
'state_id' => 1632,
'name' => 'Forráskút'
],[
'state_id' => 1632,
'name' => 'Fábiánsebestyén'
],[
'state_id' => 1632,
'name' => 'Földeák'
],[
'state_id' => 1632,
'name' => 'Hódmezővásárhely'
],[
'state_id' => 1632,
'name' => 'Hódmezővásárhelyi Járás'
],[
'state_id' => 1632,
'name' => 'Kistelek'
],[
'state_id' => 1632,
'name' => 'Kisteleki Járás'
],[
'state_id' => 1632,
'name' => 'Kiszombor'
],[
'state_id' => 1632,
'name' => 'Makó'
],[
'state_id' => 1632,
'name' => 'Makói Járás'
],[
'state_id' => 1632,
'name' => 'Maroslele'
],[
'state_id' => 1632,
'name' => 'Mindszent'
],[
'state_id' => 1632,
'name' => 'Mórahalmi Járás'
],[
'state_id' => 1632,
'name' => 'Mórahalom'
],[
'state_id' => 1632,
'name' => 'Pusztaszer'
],[
'state_id' => 1632,
'name' => 'Ruzsa'
],[
'state_id' => 1632,
'name' => 'Röszke'
],[
'state_id' => 1632,
'name' => 'Szatymaz'
],[
'state_id' => 1632,
'name' => 'Szeged'
],[
'state_id' => 1632,
'name' => 'Szegedi Járás'
],[
'state_id' => 1632,
'name' => 'Szegvár'
],[
'state_id' => 1632,
'name' => 'Szentes'
],[
'state_id' => 1632,
'name' => 'Szentesi Járás'
],[
'state_id' => 1632,
'name' => 'Székkutas'
],[
'state_id' => 1632,
'name' => 'Sándorfalva'
],[
'state_id' => 1632,
'name' => 'Tömörkény'
],[
'state_id' => 1632,
'name' => 'Zsombó'
],[
'state_id' => 1632,
'name' => 'Zákányszék'
],[
'state_id' => 1632,
'name' => 'Ásotthalom'
],[
'state_id' => 1632,
'name' => 'Ópusztaszer'
],[
'state_id' => 1632,
'name' => 'Üllés'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
