<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class FRStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 75,
'name' => 'Saint-Barthélemy',
'iso2' => 'BL'
],[
'country_id' => 75,
'name' => 'Nouvelle-Aquitaine',
'iso2' => 'NAQ'
],[
'country_id' => 75,
'name' => 'Île-de-France',
'iso2' => 'IDF'
],[
'country_id' => 75,
'name' => 'Mayotte',
'iso2' => '976'
],[
'country_id' => 75,
'name' => 'Auvergne-Rhône-Alpes',
'iso2' => 'ARA'
],[
'country_id' => 75,
'name' => 'Occitanie',
'iso2' => 'OCC'
],[
'country_id' => 75,
'name' => 'Pays-de-la-Loire',
'iso2' => 'PDL'
],[
'country_id' => 75,
'name' => 'Normandie',
'iso2' => 'NOR'
],[
'country_id' => 75,
'name' => 'Corse',
'iso2' => '20R'
],[
'country_id' => 75,
'name' => 'Bretagne',
'iso2' => 'BRE'
],[
'country_id' => 75,
'name' => 'Saint-Martin',
'iso2' => 'MF'
],[
'country_id' => 75,
'name' => 'Wallis and Futuna',
'iso2' => 'WF'
],[
'country_id' => 75,
'name' => 'Alsace',
'iso2' => '6AE'
],[
'country_id' => 75,
'name' => 'Provence-Alpes-Côte-d’Azur',
'iso2' => 'PAC'
],[
'country_id' => 75,
'name' => 'Paris',
'iso2' => '75C'
],[
'country_id' => 75,
'name' => 'Centre-Val de Loire',
'iso2' => 'CVL'
],[
'country_id' => 75,
'name' => 'Grand-Est',
'iso2' => 'GES'
],[
'country_id' => 75,
'name' => 'Saint Pierre and Miquelon',
'iso2' => 'PM'
],[
'country_id' => 75,
'name' => 'French Guiana',
'iso2' => '973'
],[
'country_id' => 75,
'name' => 'La Réunion',
'iso2' => '974'
],[
'country_id' => 75,
'name' => 'French Polynesia',
'iso2' => 'PF'
],[
'country_id' => 75,
'name' => 'Bourgogne-Franche-Comté',
'iso2' => 'BFC'
],[
'country_id' => 75,
'name' => 'Martinique',
'iso2' => '972'
],[
'country_id' => 75,
'name' => 'Hauts-de-France',
'iso2' => 'HDF'
],[
'country_id' => 75,
'name' => 'Guadeloupe',
'iso2' => '971'
],[
'country_id' => 75,
'name' => 'Ain',
'iso2' => '01'
],[
'country_id' => 75,
'name' => 'Aisne',
'iso2' => '02'
],[
'country_id' => 75,
'name' => 'Allier',
'iso2' => '03'
],[
'country_id' => 75,
'name' => 'Alpes-de-Haute-Provence',
'iso2' => '04'
],[
'country_id' => 75,
'name' => 'Hautes-Alpes',
'iso2' => '05'
],[
'country_id' => 75,
'name' => 'Alpes-Maritimes',
'iso2' => '06'
],[
'country_id' => 75,
'name' => 'Ardèche',
'iso2' => '07'
],[
'country_id' => 75,
'name' => 'Ardennes',
'iso2' => '08'
],[
'country_id' => 75,
'name' => 'Ariège',
'iso2' => '09'
],[
'country_id' => 75,
'name' => 'Aube',
'iso2' => '10'
],[
'country_id' => 75,
'name' => 'Aude',
'iso2' => '11'
],[
'country_id' => 75,
'name' => 'Aveyron',
'iso2' => '12'
],[
'country_id' => 75,
'name' => 'Bouches-du-Rhône',
'iso2' => '13'
],[
'country_id' => 75,
'name' => 'Calvados',
'iso2' => '14'
],[
'country_id' => 75,
'name' => 'Cantal',
'iso2' => '15'
],[
'country_id' => 75,
'name' => 'Charente',
'iso2' => '16'
],[
'country_id' => 75,
'name' => 'Charente-Maritime',
'iso2' => '17'
],[
'country_id' => 75,
'name' => 'Cher',
'iso2' => '18'
],[
'country_id' => 75,
'name' => 'Corrèze',
'iso2' => '19'
],[
'country_id' => 75,
'name' => 'Côte-d Or',
'iso2' => '21'
],[
'country_id' => 75,
'name' => 'Côtes-d Armor',
'iso2' => '22'
],[
'country_id' => 75,
'name' => 'Creuse',
'iso2' => '23'
],[
'country_id' => 75,
'name' => 'Dordogne',
'iso2' => '24'
],[
'country_id' => 75,
'name' => 'Doubs',
'iso2' => '25'
],[
'country_id' => 75,
'name' => 'Drôme',
'iso2' => '26'
],[
'country_id' => 75,
'name' => 'Eure',
'iso2' => '27'
],[
'country_id' => 75,
'name' => 'Eure-et-Loir',
'iso2' => '28'
],[
'country_id' => 75,
'name' => 'Finistère',
'iso2' => '29'
],[
'country_id' => 75,
'name' => 'Corse-du-Sud',
'iso2' => '2A'
],[
'country_id' => 75,
'name' => 'Haute-Corse',
'iso2' => '2B'
],[
'country_id' => 75,
'name' => 'Gard',
'iso2' => '30'
],[
'country_id' => 75,
'name' => 'Haute-Garonne',
'iso2' => '31'
],[
'country_id' => 75,
'name' => 'Gers',
'iso2' => '32'
],[
'country_id' => 75,
'name' => 'Gironde',
'iso2' => '33'
],[
'country_id' => 75,
'name' => 'Hérault',
'iso2' => '34'
],[
'country_id' => 75,
'name' => 'Ille-et-Vilaine',
'iso2' => '35'
],[
'country_id' => 75,
'name' => 'Indre',
'iso2' => '36'
],[
'country_id' => 75,
'name' => 'Indre-et-Loire',
'iso2' => '37'
],[
'country_id' => 75,
'name' => 'Isère',
'iso2' => '38'
],[
'country_id' => 75,
'name' => 'Jura',
'iso2' => '39'
],[
'country_id' => 75,
'name' => 'Landes',
'iso2' => '40'
],[
'country_id' => 75,
'name' => 'Loir-et-Cher',
'iso2' => '41'
],[
'country_id' => 75,
'name' => 'Loire',
'iso2' => '42'
],[
'country_id' => 75,
'name' => 'Haute-Loire',
'iso2' => '43'
],[
'country_id' => 75,
'name' => 'Loire-Atlantique',
'iso2' => '44'
],[
'country_id' => 75,
'name' => 'Loiret',
'iso2' => '45'
],[
'country_id' => 75,
'name' => 'Lot',
'iso2' => '46'
],[
'country_id' => 75,
'name' => 'Lot-et-Garonne',
'iso2' => '47'
],[
'country_id' => 75,
'name' => 'Lozère',
'iso2' => '48'
],[
'country_id' => 75,
'name' => 'Maine-et-Loire',
'iso2' => '49'
],[
'country_id' => 75,
'name' => 'Manche',
'iso2' => '50'
],[
'country_id' => 75,
'name' => 'Marne',
'iso2' => '51'
],[
'country_id' => 75,
'name' => 'Haute-Marne',
'iso2' => '52'
],[
'country_id' => 75,
'name' => 'Mayenne',
'iso2' => '53'
],[
'country_id' => 75,
'name' => 'Meurthe-et-Moselle',
'iso2' => '54'
],[
'country_id' => 75,
'name' => 'Meuse',
'iso2' => '55'
],[
'country_id' => 75,
'name' => 'Morbihan',
'iso2' => '56'
],[
'country_id' => 75,
'name' => 'Moselle',
'iso2' => '57'
],[
'country_id' => 75,
'name' => 'Nièvre',
'iso2' => '58'
],[
'country_id' => 75,
'name' => 'Nord',
'iso2' => '59'
],[
'country_id' => 75,
'name' => 'Oise',
'iso2' => '60'
],[
'country_id' => 75,
'name' => 'Orne',
'iso2' => '61'
],[
'country_id' => 75,
'name' => 'Pas-de-Calais',
'iso2' => '62'
],[
'country_id' => 75,
'name' => 'Puy-de-Dôme',
'iso2' => '63'
],[
'country_id' => 75,
'name' => 'Pyrénées-Atlantiques',
'iso2' => '64'
],[
'country_id' => 75,
'name' => 'Hautes-Pyrénées',
'iso2' => '65'
],[
'country_id' => 75,
'name' => 'Pyrénées-Orientales',
'iso2' => '66'
],[
'country_id' => 75,
'name' => 'Bas-Rhin',
'iso2' => '67'
],[
'country_id' => 75,
'name' => 'Haut-Rhin',
'iso2' => '68'
],[
'country_id' => 75,
'name' => 'Rhône',
'iso2' => '69'
],[
'country_id' => 75,
'name' => 'Métropole de Lyon',
'iso2' => '69M'
],[
'country_id' => 75,
'name' => 'Haute-Saône',
'iso2' => '70'
],[
'country_id' => 75,
'name' => 'Saône-et-Loire',
'iso2' => '71'
],[
'country_id' => 75,
'name' => 'Sarthe',
'iso2' => '72'
],[
'country_id' => 75,
'name' => 'Savoie',
'iso2' => '73'
],[
'country_id' => 75,
'name' => 'Haute-Savoie',
'iso2' => '74'
],[
'country_id' => 75,
'name' => 'Seine-Maritime',
'iso2' => '76'
],[
'country_id' => 75,
'name' => 'Seine-et-Marne',
'iso2' => '77'
],[
'country_id' => 75,
'name' => 'Yvelines',
'iso2' => '78'
],[
'country_id' => 75,
'name' => 'Deux-Sèvres',
'iso2' => '79'
],[
'country_id' => 75,
'name' => 'Somme',
'iso2' => '80'
],[
'country_id' => 75,
'name' => 'Tarn',
'iso2' => '81'
],[
'country_id' => 75,
'name' => 'Tarn-et-Garonne',
'iso2' => '82'
],[
'country_id' => 75,
'name' => 'Var',
'iso2' => '83'
],[
'country_id' => 75,
'name' => 'Vaucluse',
'iso2' => '84'
],[
'country_id' => 75,
'name' => 'Vendée',
'iso2' => '85'
],[
'country_id' => 75,
'name' => 'Vienne',
'iso2' => '86'
],[
'country_id' => 75,
'name' => 'Haute-Vienne',
'iso2' => '87'
],[
'country_id' => 75,
'name' => 'Vosges',
'iso2' => '88'
],[
'country_id' => 75,
'name' => 'Yonne',
'iso2' => '89'
],[
'country_id' => 75,
'name' => 'Territoire de Belfort',
'iso2' => '90'
],[
'country_id' => 75,
'name' => 'Essonne',
'iso2' => '91'
],[
'country_id' => 75,
'name' => 'Hauts-de-Seine',
'iso2' => '92'
],[
'country_id' => 75,
'name' => 'Seine-Saint-Denis',
'iso2' => '93'
],[
'country_id' => 75,
'name' => 'Val-de-Marne',
'iso2' => '94'
],[
'country_id' => 75,
'name' => 'Val-d Oise',
'iso2' => '95'
],[
'country_id' => 75,
'name' => 'Clipperton',
'iso2' => 'CP'
],[
'country_id' => 75,
'name' => 'French Southern and Antarctic Lands',
'iso2' => 'TF'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
