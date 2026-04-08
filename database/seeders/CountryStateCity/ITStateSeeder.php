<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class ITStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 107,
'name' => 'Tuscany',
'iso2' => '52'
],[
'country_id' => 107,
'name' => 'Padua',
'iso2' => 'PD'
],[
'country_id' => 107,
'name' => 'Parma',
'iso2' => 'PR'
],[
'country_id' => 107,
'name' => 'Siracusa',
'iso2' => 'SR'
],[
'country_id' => 107,
'name' => 'Palermo',
'iso2' => 'PA'
],[
'country_id' => 107,
'name' => 'Campania',
'iso2' => '72'
],[
'country_id' => 107,
'name' => 'Marche',
'iso2' => '57'
],[
'country_id' => 107,
'name' => 'Ancona',
'iso2' => 'AN'
],[
'country_id' => 107,
'name' => 'Latina',
'iso2' => 'LT'
],[
'country_id' => 107,
'name' => 'Lecce',
'iso2' => 'LE'
],[
'country_id' => 107,
'name' => 'Pavia',
'iso2' => 'PV'
],[
'country_id' => 107,
'name' => 'Lecco',
'iso2' => 'LC'
],[
'country_id' => 107,
'name' => 'Lazio',
'iso2' => '62'
],[
'country_id' => 107,
'name' => 'Abruzzo',
'iso2' => '65'
],[
'country_id' => 107,
'name' => 'Ascoli Piceno',
'iso2' => 'AP'
],[
'country_id' => 107,
'name' => 'Umbria',
'iso2' => '55'
],[
'country_id' => 107,
'name' => 'Pisa',
'iso2' => 'PI'
],[
'country_id' => 107,
'name' => 'Barletta-Andria-Trani',
'iso2' => 'BT'
],[
'country_id' => 107,
'name' => 'Pistoia',
'iso2' => 'PT'
],[
'country_id' => 107,
'name' => 'Apulia',
'iso2' => '75'
],[
'country_id' => 107,
'name' => 'Belluno',
'iso2' => 'BL'
],[
'country_id' => 107,
'name' => 'Pordenone',
'iso2' => 'PN'
],[
'country_id' => 107,
'name' => 'Perugia',
'iso2' => 'PG'
],[
'country_id' => 107,
'name' => 'Avellino',
'iso2' => 'AV'
],[
'country_id' => 107,
'name' => 'Pesaro and Urbino',
'iso2' => 'PU'
],[
'country_id' => 107,
'name' => 'Pescara',
'iso2' => 'PE'
],[
'country_id' => 107,
'name' => 'Molise',
'iso2' => '67'
],[
'country_id' => 107,
'name' => 'Piacenza',
'iso2' => 'PC'
],[
'country_id' => 107,
'name' => 'Potenza',
'iso2' => 'PZ'
],[
'country_id' => 107,
'name' => 'Prato',
'iso2' => 'PO'
],[
'country_id' => 107,
'name' => 'Benevento',
'iso2' => 'BN'
],[
'country_id' => 107,
'name' => 'Piedmont',
'iso2' => '21'
],[
'country_id' => 107,
'name' => 'Calabria',
'iso2' => '78'
],[
'country_id' => 107,
'name' => 'Bergamo',
'iso2' => 'BG'
],[
'country_id' => 107,
'name' => 'Lombardy',
'iso2' => '25'
],[
'country_id' => 107,
'name' => 'Basilicata',
'iso2' => '77'
],[
'country_id' => 107,
'name' => 'Ravenna',
'iso2' => 'RA'
],[
'country_id' => 107,
'name' => 'Reggio Emilia',
'iso2' => 'RE'
],[
'country_id' => 107,
'name' => 'Sicily',
'iso2' => '82'
],[
'country_id' => 107,
'name' => 'Rieti',
'iso2' => 'RI'
],[
'country_id' => 107,
'name' => 'Rimini',
'iso2' => 'RN'
],[
'country_id' => 107,
'name' => 'Brindisi',
'iso2' => 'BR'
],[
'country_id' => 107,
'name' => 'Sardinia',
'iso2' => '88'
],[
'country_id' => 107,
'name' => 'Aosta Valley',
'iso2' => '23'
],[
'country_id' => 107,
'name' => 'Brescia',
'iso2' => 'BS'
],[
'country_id' => 107,
'name' => 'Caltanissetta',
'iso2' => 'CL'
],[
'country_id' => 107,
'name' => 'Rovigo',
'iso2' => 'RO'
],[
'country_id' => 107,
'name' => 'Salerno',
'iso2' => 'SA'
],[
'country_id' => 107,
'name' => 'Campobasso',
'iso2' => 'CB'
],[
'country_id' => 107,
'name' => 'Sassari',
'iso2' => 'SS'
],[
'country_id' => 107,
'name' => 'Enna',
'iso2' => 'EN'
],[
'country_id' => 107,
'name' => 'Trentino-South Tyrol',
'iso2' => '32'
],[
'country_id' => 107,
'name' => 'Verbano-Cusio-Ossola',
'iso2' => 'VB'
],[
'country_id' => 107,
'name' => 'Agrigento',
'iso2' => 'AG'
],[
'country_id' => 107,
'name' => 'Catanzaro',
'iso2' => 'CZ'
],[
'country_id' => 107,
'name' => 'Ragusa',
'iso2' => 'RG'
],[
'country_id' => 107,
'name' => 'South Sardinia',
'iso2' => 'SU'
],[
'country_id' => 107,
'name' => 'Caserta',
'iso2' => 'CE'
],[
'country_id' => 107,
'name' => 'Savona',
'iso2' => 'SV'
],[
'country_id' => 107,
'name' => 'Trapani',
'iso2' => 'TP'
],[
'country_id' => 107,
'name' => 'Siena',
'iso2' => 'SI'
],[
'country_id' => 107,
'name' => 'Viterbo',
'iso2' => 'VT'
],[
'country_id' => 107,
'name' => 'Verona',
'iso2' => 'VR'
],[
'country_id' => 107,
'name' => 'Vibo Valentia',
'iso2' => 'VV'
],[
'country_id' => 107,
'name' => 'Vicenza',
'iso2' => 'VI'
],[
'country_id' => 107,
'name' => 'Chieti',
'iso2' => 'CH'
],[
'country_id' => 107,
'name' => 'Como',
'iso2' => 'CO'
],[
'country_id' => 107,
'name' => 'Sondrio',
'iso2' => 'SO'
],[
'country_id' => 107,
'name' => 'Cosenza',
'iso2' => 'CS'
],[
'country_id' => 107,
'name' => 'Taranto',
'iso2' => 'TA'
],[
'country_id' => 107,
'name' => 'Fermo',
'iso2' => 'FM'
],[
'country_id' => 107,
'name' => 'Livorno',
'iso2' => 'LI'
],[
'country_id' => 107,
'name' => 'Ferrara',
'iso2' => 'FE'
],[
'country_id' => 107,
'name' => 'Lodi',
'iso2' => 'LO'
],[
'country_id' => 107,
'name' => 'Lucca',
'iso2' => 'LU'
],[
'country_id' => 107,
'name' => 'Macerata',
'iso2' => 'MC'
],[
'country_id' => 107,
'name' => 'Cremona',
'iso2' => 'CR'
],[
'country_id' => 107,
'name' => 'Teramo',
'iso2' => 'TE'
],[
'country_id' => 107,
'name' => 'Veneto',
'iso2' => '34'
],[
'country_id' => 107,
'name' => 'Crotone',
'iso2' => 'KR'
],[
'country_id' => 107,
'name' => 'Terni',
'iso2' => 'TR'
],[
'country_id' => 107,
'name' => 'Friuli–Venezia Giulia',
'iso2' => '36'
],[
'country_id' => 107,
'name' => 'Modena',
'iso2' => 'MO'
],[
'country_id' => 107,
'name' => 'Mantua',
'iso2' => 'MN'
],[
'country_id' => 107,
'name' => 'Massa and Carrara',
'iso2' => 'MS'
],[
'country_id' => 107,
'name' => 'Matera',
'iso2' => 'MT'
],[
'country_id' => 107,
'name' => 'Medio Campidano',
'iso2' => 'VS'
],[
'country_id' => 107,
'name' => 'Treviso',
'iso2' => 'TV'
],[
'country_id' => 107,
'name' => 'Trieste',
'iso2' => 'TS'
],[
'country_id' => 107,
'name' => 'Udine',
'iso2' => 'UD'
],[
'country_id' => 107,
'name' => 'Varese',
'iso2' => 'VA'
],[
'country_id' => 107,
'name' => 'Liguria',
'iso2' => '42'
],[
'country_id' => 107,
'name' => 'Monza and Brianza',
'iso2' => 'MB'
],[
'country_id' => 107,
'name' => 'Foggia',
'iso2' => 'FG'
],[
'country_id' => 107,
'name' => 'Emilia-Romagna',
'iso2' => '45'
],[
'country_id' => 107,
'name' => 'Novara',
'iso2' => 'NO'
],[
'country_id' => 107,
'name' => 'Cuneo',
'iso2' => 'CN'
],[
'country_id' => 107,
'name' => 'Frosinone',
'iso2' => 'FR'
],[
'country_id' => 107,
'name' => 'Gorizia',
'iso2' => 'GO'
],[
'country_id' => 107,
'name' => 'Biella',
'iso2' => 'BI'
],[
'country_id' => 107,
'name' => 'Forlì-Cesena',
'iso2' => 'FC'
],[
'country_id' => 107,
'name' => 'Asti',
'iso2' => 'AT'
],[
'country_id' => 107,
'name' => 'L\'Aquila',
'iso2' => 'AQ'
],[
'country_id' => 107,
'name' => 'Alessandria',
'iso2' => 'AL'
],[
'country_id' => 107,
'name' => 'Vercelli',
'iso2' => 'VC'
],[
'country_id' => 107,
'name' => 'Oristano',
'iso2' => 'OR'
],[
'country_id' => 107,
'name' => 'Grosseto',
'iso2' => 'GR'
],[
'country_id' => 107,
'name' => 'Imperia',
'iso2' => 'IM'
],[
'country_id' => 107,
'name' => 'Isernia',
'iso2' => 'IS'
],[
'country_id' => 107,
'name' => 'Nuoro',
'iso2' => 'NU'
],[
'country_id' => 107,
'name' => 'La Spezia',
'iso2' => 'SP'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
