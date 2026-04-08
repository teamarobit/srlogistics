<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CZState53CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1009,
'name' => 'Brandýs nad Orlicí'
],[
'state_id' => 1009,
'name' => 'Brněnec'
],[
'state_id' => 1009,
'name' => 'Bystré'
],[
'state_id' => 1009,
'name' => 'Bystřec'
],[
'state_id' => 1009,
'name' => 'Býšť'
],[
'state_id' => 1009,
'name' => 'Březová nad Svitavou'
],[
'state_id' => 1009,
'name' => 'Choceň'
],[
'state_id' => 1009,
'name' => 'Chrast'
],[
'state_id' => 1009,
'name' => 'Chroustovice'
],[
'state_id' => 1009,
'name' => 'Chrudim'
],[
'state_id' => 1009,
'name' => 'Chvaletice'
],[
'state_id' => 1009,
'name' => 'Dašice'
],[
'state_id' => 1009,
'name' => 'Dlouhá Třebová'
],[
'state_id' => 1009,
'name' => 'Dolní Dobrouč'
],[
'state_id' => 1009,
'name' => 'Dolní Roveň'
],[
'state_id' => 1009,
'name' => 'Dolní Sloupnice'
],[
'state_id' => 1009,
'name' => 'Dolní Újezd'
],[
'state_id' => 1009,
'name' => 'Dolní Čermná'
],[
'state_id' => 1009,
'name' => 'Heřmanův Městec'
],[
'state_id' => 1009,
'name' => 'Hlinsko'
],[
'state_id' => 1009,
'name' => 'Holice'
],[
'state_id' => 1009,
'name' => 'Horní Jelení'
],[
'state_id' => 1009,
'name' => 'Horní Sloupnice'
],[
'state_id' => 1009,
'name' => 'Horní Čermná'
],[
'state_id' => 1009,
'name' => 'Hradec nad Svitavou'
],[
'state_id' => 1009,
'name' => 'Hrochův Týnec'
],[
'state_id' => 1009,
'name' => 'Jablonné nad Orlicí'
],[
'state_id' => 1009,
'name' => 'Jaroměřice'
],[
'state_id' => 1009,
'name' => 'Jedlová'
],[
'state_id' => 1009,
'name' => 'Jevíčko'
],[
'state_id' => 1009,
'name' => 'Krouna'
],[
'state_id' => 1009,
'name' => 'Králíky'
],[
'state_id' => 1009,
'name' => 'Kunvald'
],[
'state_id' => 1009,
'name' => 'Kunčina'
],[
'state_id' => 1009,
'name' => 'Lanškroun'
],[
'state_id' => 1009,
'name' => 'Letohrad'
],[
'state_id' => 1009,
'name' => 'Litomyšl'
],[
'state_id' => 1009,
'name' => 'Lukavice'
],[
'state_id' => 1009,
'name' => 'Luže'
],[
'state_id' => 1009,
'name' => 'Lázně Bohdaneč'
],[
'state_id' => 1009,
'name' => 'Miřetice'
],[
'state_id' => 1009,
'name' => 'Moravany'
],[
'state_id' => 1009,
'name' => 'Moravská Třebová'
],[
'state_id' => 1009,
'name' => 'Městečko Trnávka'
],[
'state_id' => 1009,
'name' => 'Nasavrky'
],[
'state_id' => 1009,
'name' => 'Okres Chrudim'
],[
'state_id' => 1009,
'name' => 'Okres Pardubice'
],[
'state_id' => 1009,
'name' => 'Okres Svitavy'
],[
'state_id' => 1009,
'name' => 'Okres Ústí nad Orlicí'
],[
'state_id' => 1009,
'name' => 'Opatov'
],[
'state_id' => 1009,
'name' => 'Opatovice nad Labem'
],[
'state_id' => 1009,
'name' => 'Osík'
],[
'state_id' => 1009,
'name' => 'Pardubice'
],[
'state_id' => 1009,
'name' => 'Polička'
],[
'state_id' => 1009,
'name' => 'Pomezí'
],[
'state_id' => 1009,
'name' => 'Prachovice'
],[
'state_id' => 1009,
'name' => 'Proseč'
],[
'state_id' => 1009,
'name' => 'Přelouč'
],[
'state_id' => 1009,
'name' => 'Radiměř'
],[
'state_id' => 1009,
'name' => 'Ronov nad Doubravou'
],[
'state_id' => 1009,
'name' => 'Rosice'
],[
'state_id' => 1009,
'name' => 'Rybitví'
],[
'state_id' => 1009,
'name' => 'Sezemice'
],[
'state_id' => 1009,
'name' => 'Seč'
],[
'state_id' => 1009,
'name' => 'Skuteč'
],[
'state_id' => 1009,
'name' => 'Slatiňany'
],[
'state_id' => 1009,
'name' => 'Staré Hradiště'
],[
'state_id' => 1009,
'name' => 'Svitavy'
],[
'state_id' => 1009,
'name' => 'Třemošnice'
],[
'state_id' => 1009,
'name' => 'Vysoké Mýto'
],[
'state_id' => 1009,
'name' => 'Ústí nad Orlicí'
],[
'state_id' => 1009,
'name' => 'Červená Voda'
],[
'state_id' => 1009,
'name' => 'Česká Třebová'
],[
'state_id' => 1009,
'name' => 'Řečany nad Labem'
],[
'state_id' => 1009,
'name' => 'Žamberk'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
