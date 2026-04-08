<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CZState51CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1021,
'name' => 'Benecko'
],[
'state_id' => 1021,
'name' => 'Brniště'
],[
'state_id' => 1021,
'name' => 'Chrastava'
],[
'state_id' => 1021,
'name' => 'Cvikov'
],[
'state_id' => 1021,
'name' => 'Desná'
],[
'state_id' => 1021,
'name' => 'Doksy'
],[
'state_id' => 1021,
'name' => 'Dubá'
],[
'state_id' => 1021,
'name' => 'Frýdlant'
],[
'state_id' => 1021,
'name' => 'Harrachov'
],[
'state_id' => 1021,
'name' => 'Hejnice'
],[
'state_id' => 1021,
'name' => 'Hodkovice nad Mohelkou'
],[
'state_id' => 1021,
'name' => 'Horní Branná'
],[
'state_id' => 1021,
'name' => 'Hrádek nad Nisou'
],[
'state_id' => 1021,
'name' => 'Jablonec nad Jizerou'
],[
'state_id' => 1021,
'name' => 'Jablonec nad Nisou'
],[
'state_id' => 1021,
'name' => 'Jablonné v Podještědí'
],[
'state_id' => 1021,
'name' => 'Janov nad Nisou'
],[
'state_id' => 1021,
'name' => 'Jilemnice'
],[
'state_id' => 1021,
'name' => 'Josefův Důl'
],[
'state_id' => 1021,
'name' => 'Kamenický Šenov'
],[
'state_id' => 1021,
'name' => 'Kořenov'
],[
'state_id' => 1021,
'name' => 'Košťálov'
],[
'state_id' => 1021,
'name' => 'Liberec'
],[
'state_id' => 1021,
'name' => 'Lomnice nad Popelkou'
],[
'state_id' => 1021,
'name' => 'Lučany nad Nisou'
],[
'state_id' => 1021,
'name' => 'Malá Skála'
],[
'state_id' => 1021,
'name' => 'Mimoň'
],[
'state_id' => 1021,
'name' => 'Mníšek'
],[
'state_id' => 1021,
'name' => 'Nové Město pod Smrkem'
],[
'state_id' => 1021,
'name' => 'Nový Bor'
],[
'state_id' => 1021,
'name' => 'Ohrazenice'
],[
'state_id' => 1021,
'name' => 'Okres Jablonec nad Nisou'
],[
'state_id' => 1021,
'name' => 'Okres Liberec'
],[
'state_id' => 1021,
'name' => 'Okres Semily'
],[
'state_id' => 1021,
'name' => 'Okres Česká Lípa'
],[
'state_id' => 1021,
'name' => 'Osečná'
],[
'state_id' => 1021,
'name' => 'Plavy'
],[
'state_id' => 1021,
'name' => 'Poniklá'
],[
'state_id' => 1021,
'name' => 'Pěnčín'
],[
'state_id' => 1021,
'name' => 'Příšovice'
],[
'state_id' => 1021,
'name' => 'Raspenava'
],[
'state_id' => 1021,
'name' => 'Rokytnice nad Jizerou'
],[
'state_id' => 1021,
'name' => 'Rovensko pod Troskami'
],[
'state_id' => 1021,
'name' => 'Semily'
],[
'state_id' => 1021,
'name' => 'Smržovka'
],[
'state_id' => 1021,
'name' => 'Stráž nad Nisou'
],[
'state_id' => 1021,
'name' => 'Stráž pod Ralskem'
],[
'state_id' => 1021,
'name' => 'Studenec'
],[
'state_id' => 1021,
'name' => 'Tanvald'
],[
'state_id' => 1021,
'name' => 'Turnov'
],[
'state_id' => 1021,
'name' => 'Valdice'
],[
'state_id' => 1021,
'name' => 'Velké Hamry'
],[
'state_id' => 1021,
'name' => 'Višňova'
],[
'state_id' => 1021,
'name' => 'Vysoké nad Jizerou'
],[
'state_id' => 1021,
'name' => 'Zákupy'
],[
'state_id' => 1021,
'name' => 'Česká Lípa'
],[
'state_id' => 1021,
'name' => 'Český Dub'
],[
'state_id' => 1021,
'name' => 'Žandov'
],[
'state_id' => 1021,
'name' => 'Železný Brod'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
