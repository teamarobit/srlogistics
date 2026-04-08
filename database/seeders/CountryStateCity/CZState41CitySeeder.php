<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CZState41CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1004,
'name' => 'Abertamy'
],[
'state_id' => 1004,
'name' => 'Aš'
],[
'state_id' => 1004,
'name' => 'Bochov'
],[
'state_id' => 1004,
'name' => 'Bukovany'
],[
'state_id' => 1004,
'name' => 'Březová'
],[
'state_id' => 1004,
'name' => 'Cheb'
],[
'state_id' => 1004,
'name' => 'Chodov'
],[
'state_id' => 1004,
'name' => 'Dalovice'
],[
'state_id' => 1004,
'name' => 'Dolní Rychnov'
],[
'state_id' => 1004,
'name' => 'Dolní Žandov'
],[
'state_id' => 1004,
'name' => 'Františkovy Lázně'
],[
'state_id' => 1004,
'name' => 'Habartov'
],[
'state_id' => 1004,
'name' => 'Hazlov'
],[
'state_id' => 1004,
'name' => 'Horní Slavkov'
],[
'state_id' => 1004,
'name' => 'Hranice'
],[
'state_id' => 1004,
'name' => 'Hroznětín'
],[
'state_id' => 1004,
'name' => 'Jáchymov'
],[
'state_id' => 1004,
'name' => 'Karlovy Vary'
],[
'state_id' => 1004,
'name' => 'Klášter'
],[
'state_id' => 1004,
'name' => 'Kraslice'
],[
'state_id' => 1004,
'name' => 'Kynšperk nad Ohří'
],[
'state_id' => 1004,
'name' => 'Loket'
],[
'state_id' => 1004,
'name' => 'Lomnice'
],[
'state_id' => 1004,
'name' => 'Luby'
],[
'state_id' => 1004,
'name' => 'Lázně Kynžvart'
],[
'state_id' => 1004,
'name' => 'Mariánské Lázně'
],[
'state_id' => 1004,
'name' => 'Merklín'
],[
'state_id' => 1004,
'name' => 'Město'
],[
'state_id' => 1004,
'name' => 'Nejdek'
],[
'state_id' => 1004,
'name' => 'Nová Role'
],[
'state_id' => 1004,
'name' => 'Nové Sedlo'
],[
'state_id' => 1004,
'name' => 'Okres Cheb'
],[
'state_id' => 1004,
'name' => 'Okres Karlovy Vary'
],[
'state_id' => 1004,
'name' => 'Okres Sokolov'
],[
'state_id' => 1004,
'name' => 'Oloví'
],[
'state_id' => 1004,
'name' => 'Ostrov'
],[
'state_id' => 1004,
'name' => 'Plesná'
],[
'state_id' => 1004,
'name' => 'Rotava'
],[
'state_id' => 1004,
'name' => 'Sadov'
],[
'state_id' => 1004,
'name' => 'Skalná'
],[
'state_id' => 1004,
'name' => 'Sokolov'
],[
'state_id' => 1004,
'name' => 'Svatava'
],[
'state_id' => 1004,
'name' => 'Toužim'
],[
'state_id' => 1004,
'name' => 'Velká Hleďsebe'
],[
'state_id' => 1004,
'name' => 'Vintířov'
],[
'state_id' => 1004,
'name' => 'Žlutice'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
