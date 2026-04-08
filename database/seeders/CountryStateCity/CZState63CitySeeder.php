<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CZState63CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 999,
'name' => 'Batelov'
],[
'state_id' => 999,
'name' => 'Bohdalov'
],[
'state_id' => 999,
'name' => 'Brtnice'
],[
'state_id' => 999,
'name' => 'Budišov'
],[
'state_id' => 999,
'name' => 'Bystřice nad Pernštejnem'
],[
'state_id' => 999,
'name' => 'Chotěboř'
],[
'state_id' => 999,
'name' => 'Dobronín'
],[
'state_id' => 999,
'name' => 'Dolní Cerekev'
],[
'state_id' => 999,
'name' => 'Golčův Jeníkov'
],[
'state_id' => 999,
'name' => 'Habry'
],[
'state_id' => 999,
'name' => 'Havlíčkův Brod'
],[
'state_id' => 999,
'name' => 'Herálec'
],[
'state_id' => 999,
'name' => 'Horní Cerekev'
],[
'state_id' => 999,
'name' => 'Hrotovice'
],[
'state_id' => 999,
'name' => 'Humpolec'
],[
'state_id' => 999,
'name' => 'Jaroměřice nad Rokytnou'
],[
'state_id' => 999,
'name' => 'Jemnice'
],[
'state_id' => 999,
'name' => 'Jihlava'
],[
'state_id' => 999,
'name' => 'Jimramov'
],[
'state_id' => 999,
'name' => 'Kamenice'
],[
'state_id' => 999,
'name' => 'Kamenice nad Lipou'
],[
'state_id' => 999,
'name' => 'Kněžice'
],[
'state_id' => 999,
'name' => 'Křižanov'
],[
'state_id' => 999,
'name' => 'Křížová'
],[
'state_id' => 999,
'name' => 'Ledeč nad Sázavou'
],[
'state_id' => 999,
'name' => 'Luka nad Jihlavou'
],[
'state_id' => 999,
'name' => 'Lukavec'
],[
'state_id' => 999,
'name' => 'Lípa'
],[
'state_id' => 999,
'name' => 'Mohelno'
],[
'state_id' => 999,
'name' => 'Moravské Budějovice'
],[
'state_id' => 999,
'name' => 'Měřín'
],[
'state_id' => 999,
'name' => 'Nová Cerekev'
],[
'state_id' => 999,
'name' => 'Nové Město na Moravě'
],[
'state_id' => 999,
'name' => 'Nové Syrovice'
],[
'state_id' => 999,
'name' => 'Nové Veselí'
],[
'state_id' => 999,
'name' => 'Náměšť nad Oslavou'
],[
'state_id' => 999,
'name' => 'Okres Havlíčkův Brod'
],[
'state_id' => 999,
'name' => 'Okres Jihlava'
],[
'state_id' => 999,
'name' => 'Okres Pelhřimov'
],[
'state_id' => 999,
'name' => 'Okres Třebíč'
],[
'state_id' => 999,
'name' => 'Okres Žďár nad Sázavou'
],[
'state_id' => 999,
'name' => 'Okrouhlice'
],[
'state_id' => 999,
'name' => 'Okříšky'
],[
'state_id' => 999,
'name' => 'Pacov'
],[
'state_id' => 999,
'name' => 'Pelhřimov'
],[
'state_id' => 999,
'name' => 'Polná'
],[
'state_id' => 999,
'name' => 'Počátky'
],[
'state_id' => 999,
'name' => 'Přibyslav'
],[
'state_id' => 999,
'name' => 'Rouchovany'
],[
'state_id' => 999,
'name' => 'Stařeč'
],[
'state_id' => 999,
'name' => 'Svratka'
],[
'state_id' => 999,
'name' => 'Světlá nad Sázavou'
],[
'state_id' => 999,
'name' => 'Telč'
],[
'state_id' => 999,
'name' => 'Třebíč'
],[
'state_id' => 999,
'name' => 'Třešť'
],[
'state_id' => 999,
'name' => 'Velká Bíteš'
],[
'state_id' => 999,
'name' => 'Velké Meziříčí'
],[
'state_id' => 999,
'name' => 'Velký Beranov'
],[
'state_id' => 999,
'name' => 'Vilémov'
],[
'state_id' => 999,
'name' => 'Vladislav'
],[
'state_id' => 999,
'name' => 'Černovice'
],[
'state_id' => 999,
'name' => 'Štoky'
],[
'state_id' => 999,
'name' => 'Želetava'
],[
'state_id' => 999,
'name' => 'Želiv'
],[
'state_id' => 999,
'name' => 'Žirovnice'
],[
'state_id' => 999,
'name' => 'Žďár nad Sázavou'
],[
'state_id' => 999,
'name' => 'Žďár nad Sázavou Druhy'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
