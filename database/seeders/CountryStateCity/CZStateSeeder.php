<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class CZStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 58,
'name' => 'Břeclav',
'iso2' => '644'
],[
'country_id' => 58,
'name' => 'Český Krumlov',
'iso2' => '312'
],[
'country_id' => 58,
'name' => 'Plzeň-město',
'iso2' => '323'
],[
'country_id' => 58,
'name' => 'Brno-venkov',
'iso2' => '643'
],[
'country_id' => 58,
'name' => 'Příbram',
'iso2' => '20B'
],[
'country_id' => 58,
'name' => 'Pardubice',
'iso2' => '532'
],[
'country_id' => 58,
'name' => 'Nový Jičín',
'iso2' => '804'
],[
'country_id' => 58,
'name' => 'Náchod',
'iso2' => '523'
],[
'country_id' => 58,
'name' => 'Prostějov',
'iso2' => '713'
],[
'country_id' => 58,
'name' => 'Zlínský kraj',
'iso2' => '72'
],[
'country_id' => 58,
'name' => 'Chomutov',
'iso2' => '422'
],[
'country_id' => 58,
'name' => 'Středočeský kraj',
'iso2' => '20'
],[
'country_id' => 58,
'name' => 'České Budějovice',
'iso2' => '311'
],[
'country_id' => 58,
'name' => 'Rakovník',
'iso2' => '20C'
],[
'country_id' => 58,
'name' => 'Frýdek-Místek',
'iso2' => '802'
],[
'country_id' => 58,
'name' => 'Písek',
'iso2' => '314'
],[
'country_id' => 58,
'name' => 'Hodonín',
'iso2' => '645'
],[
'country_id' => 58,
'name' => 'Zlín',
'iso2' => '724'
],[
'country_id' => 58,
'name' => 'Plzeň-sever',
'iso2' => '325'
],[
'country_id' => 58,
'name' => 'Tábor',
'iso2' => '317'
],[
'country_id' => 58,
'name' => 'Brno-město',
'iso2' => '642'
],[
'country_id' => 58,
'name' => 'Svitavy',
'iso2' => '533'
],[
'country_id' => 58,
'name' => 'Vsetín',
'iso2' => '723'
],[
'country_id' => 58,
'name' => 'Cheb',
'iso2' => '411'
],[
'country_id' => 58,
'name' => 'Olomouc',
'iso2' => '712'
],[
'country_id' => 58,
'name' => 'Kraj Vysočina',
'iso2' => '63'
],[
'country_id' => 58,
'name' => 'Ústecký kraj',
'iso2' => '42'
],[
'country_id' => 58,
'name' => 'Prachatice',
'iso2' => '315'
],[
'country_id' => 58,
'name' => 'Trutnov',
'iso2' => '525'
],[
'country_id' => 58,
'name' => 'Hradec Králové',
'iso2' => '521'
],[
'country_id' => 58,
'name' => 'Karlovarský kraj',
'iso2' => '41'
],[
'country_id' => 58,
'name' => 'Nymburk',
'iso2' => '208'
],[
'country_id' => 58,
'name' => 'Rokycany',
'iso2' => '326'
],[
'country_id' => 58,
'name' => 'Ostrava-město',
'iso2' => '806'
],[
'country_id' => 58,
'name' => 'Karviná',
'iso2' => '803'
],[
'country_id' => 58,
'name' => 'Pardubický kraj',
'iso2' => '53'
],[
'country_id' => 58,
'name' => 'Olomoucký kraj',
'iso2' => '71'
],[
'country_id' => 58,
'name' => 'Liberec',
'iso2' => '513'
],[
'country_id' => 58,
'name' => 'Klatovy',
'iso2' => '322'
],[
'country_id' => 58,
'name' => 'Uherské Hradiště',
'iso2' => '722'
],[
'country_id' => 58,
'name' => 'Kroměříž',
'iso2' => '721'
],[
'country_id' => 58,
'name' => 'Sokolov',
'iso2' => '413'
],[
'country_id' => 58,
'name' => 'Semily',
'iso2' => '514'
],[
'country_id' => 58,
'name' => 'Třebíč',
'iso2' => '634'
],[
'country_id' => 58,
'name' => 'Praha, Hlavní město',
'iso2' => '10'
],[
'country_id' => 58,
'name' => 'Ústí nad Labem',
'iso2' => '427'
],[
'country_id' => 58,
'name' => 'Moravskoslezský kraj',
'iso2' => '80'
],[
'country_id' => 58,
'name' => 'Liberecký kraj',
'iso2' => '51'
],[
'country_id' => 58,
'name' => 'Jihomoravský kraj',
'iso2' => '64'
],[
'country_id' => 58,
'name' => 'Karlovy Vary',
'iso2' => '412'
],[
'country_id' => 58,
'name' => 'Litoměřice',
'iso2' => '423'
],[
'country_id' => 58,
'name' => 'Praha-východ',
'iso2' => '209'
],[
'country_id' => 58,
'name' => 'Plzeňský kraj',
'iso2' => '32'
],[
'country_id' => 58,
'name' => 'Plzeň-jih',
'iso2' => '324'
],[
'country_id' => 58,
'name' => 'Děčín',
'iso2' => '421'
],[
'country_id' => 58,
'name' => 'Havlíčkův Brod',
'iso2' => '631'
],[
'country_id' => 58,
'name' => 'Jablonec nad Nisou',
'iso2' => '512'
],[
'country_id' => 58,
'name' => 'Jihlava',
'iso2' => '632'
],[
'country_id' => 58,
'name' => 'Královéhradecký kraj',
'iso2' => '52'
],[
'country_id' => 58,
'name' => 'Blansko',
'iso2' => '641'
],[
'country_id' => 58,
'name' => 'Louny',
'iso2' => '424'
],[
'country_id' => 58,
'name' => 'Kolín',
'iso2' => '204'
],[
'country_id' => 58,
'name' => 'Praha-západ',
'iso2' => '20A'
],[
'country_id' => 58,
'name' => 'Beroun',
'iso2' => '202'
],[
'country_id' => 58,
'name' => 'Teplice',
'iso2' => '426'
],[
'country_id' => 58,
'name' => 'Vyškov',
'iso2' => '646'
],[
'country_id' => 58,
'name' => 'Opava',
'iso2' => '805'
],[
'country_id' => 58,
'name' => 'Jindřichův Hradec',
'iso2' => '313'
],[
'country_id' => 58,
'name' => 'Jeseník',
'iso2' => '711'
],[
'country_id' => 58,
'name' => 'Přerov',
'iso2' => '714'
],[
'country_id' => 58,
'name' => 'Benešov',
'iso2' => '201'
],[
'country_id' => 58,
'name' => 'Strakonice',
'iso2' => '316'
],[
'country_id' => 58,
'name' => 'Most',
'iso2' => '425'
],[
'country_id' => 58,
'name' => 'Znojmo',
'iso2' => '647'
],[
'country_id' => 58,
'name' => 'Kladno',
'iso2' => '203'
],[
'country_id' => 58,
'name' => 'Česká Lípa',
'iso2' => '511'
],[
'country_id' => 58,
'name' => 'Chrudim',
'iso2' => '531'
],[
'country_id' => 58,
'name' => 'Rychnov nad Kněžnou',
'iso2' => '524'
],[
'country_id' => 58,
'name' => 'Mělník',
'iso2' => '206'
],[
'country_id' => 58,
'name' => 'Jihočeský kraj',
'iso2' => '31'
],[
'country_id' => 58,
'name' => 'Jičín',
'iso2' => '522'
],[
'country_id' => 58,
'name' => 'Domažlice',
'iso2' => '321'
],[
'country_id' => 58,
'name' => 'Šumperk',
'iso2' => '715'
],[
'country_id' => 58,
'name' => 'Mladá Boleslav',
'iso2' => '207'
],[
'country_id' => 58,
'name' => 'Bruntál',
'iso2' => '801'
],[
'country_id' => 58,
'name' => 'Pelhřimov',
'iso2' => '633'
],[
'country_id' => 58,
'name' => 'Tachov',
'iso2' => '327'
],[
'country_id' => 58,
'name' => 'Ústí nad Orlicí',
'iso2' => '534'
],[
'country_id' => 58,
'name' => 'Žďár nad Sázavou',
'iso2' => '635'
],[
'country_id' => 58,
'name' => 'Kutná Hora',
'iso2' => '205'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
