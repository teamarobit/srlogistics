<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CZState42CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1000,
'name' => 'Bechlín'
],[
'state_id' => 1000,
'name' => 'Benešov nad Ploučnicí'
],[
'state_id' => 1000,
'name' => 'Bečov'
],[
'state_id' => 1000,
'name' => 'Bohušovice nad Ohří'
],[
'state_id' => 1000,
'name' => 'Braňany'
],[
'state_id' => 1000,
'name' => 'Budyně nad Ohří'
],[
'state_id' => 1000,
'name' => 'Bystřany'
],[
'state_id' => 1000,
'name' => 'Bílina'
],[
'state_id' => 1000,
'name' => 'Bílina Kyselka'
],[
'state_id' => 1000,
'name' => 'Březno'
],[
'state_id' => 1000,
'name' => 'Chabařovice'
],[
'state_id' => 1000,
'name' => 'Chlumec'
],[
'state_id' => 1000,
'name' => 'Chomutov'
],[
'state_id' => 1000,
'name' => 'Chřibská'
],[
'state_id' => 1000,
'name' => 'Dobroměřice'
],[
'state_id' => 1000,
'name' => 'Dolní Podluží'
],[
'state_id' => 1000,
'name' => 'Dolní Poustevna'
],[
'state_id' => 1000,
'name' => 'Dubí'
],[
'state_id' => 1000,
'name' => 'Duchcov'
],[
'state_id' => 1000,
'name' => 'Děčín'
],[
'state_id' => 1000,
'name' => 'Horní Jiřetín'
],[
'state_id' => 1000,
'name' => 'Hostomice'
],[
'state_id' => 1000,
'name' => 'Hošťka'
],[
'state_id' => 1000,
'name' => 'Hrob'
],[
'state_id' => 1000,
'name' => 'Jirkov'
],[
'state_id' => 1000,
'name' => 'Jiříkov'
],[
'state_id' => 1000,
'name' => 'Jílové'
],[
'state_id' => 1000,
'name' => 'Kadaň'
],[
'state_id' => 1000,
'name' => 'Klášterec nad Ohří'
],[
'state_id' => 1000,
'name' => 'Kovářská'
],[
'state_id' => 1000,
'name' => 'Košťany'
],[
'state_id' => 1000,
'name' => 'Krupka'
],[
'state_id' => 1000,
'name' => 'Kryry'
],[
'state_id' => 1000,
'name' => 'Krásná Lípa'
],[
'state_id' => 1000,
'name' => 'Křešice'
],[
'state_id' => 1000,
'name' => 'Lenešice'
],[
'state_id' => 1000,
'name' => 'Libochovice'
],[
'state_id' => 1000,
'name' => 'Libouchec'
],[
'state_id' => 1000,
'name' => 'Liběšice'
],[
'state_id' => 1000,
'name' => 'Litoměřice'
],[
'state_id' => 1000,
'name' => 'Litvínov'
],[
'state_id' => 1000,
'name' => 'Lom u Mostu'
],[
'state_id' => 1000,
'name' => 'Louny'
],[
'state_id' => 1000,
'name' => 'Lovosice'
],[
'state_id' => 1000,
'name' => 'Lubenec'
],[
'state_id' => 1000,
'name' => 'Meziboři'
],[
'state_id' => 1000,
'name' => 'Mikulášovice'
],[
'state_id' => 1000,
'name' => 'Most'
],[
'state_id' => 1000,
'name' => 'Měcholupy'
],[
'state_id' => 1000,
'name' => 'Novosedlice'
],[
'state_id' => 1000,
'name' => 'Obrnice'
],[
'state_id' => 1000,
'name' => 'Okres Chomutov'
],[
'state_id' => 1000,
'name' => 'Okres Děčín'
],[
'state_id' => 1000,
'name' => 'Okres Litoměřice'
],[
'state_id' => 1000,
'name' => 'Okres Louny'
],[
'state_id' => 1000,
'name' => 'Okres Most'
],[
'state_id' => 1000,
'name' => 'Okres Teplice'
],[
'state_id' => 1000,
'name' => 'Okres Ústí nad Labem'
],[
'state_id' => 1000,
'name' => 'Osek'
],[
'state_id' => 1000,
'name' => 'Peruc'
],[
'state_id' => 1000,
'name' => 'Perštejn'
],[
'state_id' => 1000,
'name' => 'Podbořany'
],[
'state_id' => 1000,
'name' => 'Polepy'
],[
'state_id' => 1000,
'name' => 'Postoloprty'
],[
'state_id' => 1000,
'name' => 'Povrly'
],[
'state_id' => 1000,
'name' => 'Proboštov'
],[
'state_id' => 1000,
'name' => 'Radonice'
],[
'state_id' => 1000,
'name' => 'Roudnice nad Labem'
],[
'state_id' => 1000,
'name' => 'Rumburk'
],[
'state_id' => 1000,
'name' => 'Staré Křečany'
],[
'state_id' => 1000,
'name' => 'Teplice'
],[
'state_id' => 1000,
'name' => 'Terezín'
],[
'state_id' => 1000,
'name' => 'Trmice'
],[
'state_id' => 1000,
'name' => 'Třebenice'
],[
'state_id' => 1000,
'name' => 'Varnsdorf'
],[
'state_id' => 1000,
'name' => 'Vejprty'
],[
'state_id' => 1000,
'name' => 'Velemín'
],[
'state_id' => 1000,
'name' => 'Velké Březno'
],[
'state_id' => 1000,
'name' => 'Velký Šenov'
],[
'state_id' => 1000,
'name' => 'Verneřice'
],[
'state_id' => 1000,
'name' => 'Vilémov'
],[
'state_id' => 1000,
'name' => 'Vroutek'
],[
'state_id' => 1000,
'name' => 'Zabrušany'
],[
'state_id' => 1000,
'name' => 'Údlice'
],[
'state_id' => 1000,
'name' => 'Úštěk'
],[
'state_id' => 1000,
'name' => 'Černčice'
],[
'state_id' => 1000,
'name' => 'Česká Kamenice'
],[
'state_id' => 1000,
'name' => 'Čížkovice'
],[
'state_id' => 1000,
'name' => 'Řehlovice'
],[
'state_id' => 1000,
'name' => 'Šluknov'
],[
'state_id' => 1000,
'name' => 'Štětí'
],[
'state_id' => 1000,
'name' => 'Žatec'
],[
'state_id' => 1000,
'name' => 'Žitenice'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
