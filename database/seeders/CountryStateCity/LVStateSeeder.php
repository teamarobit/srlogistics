<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class LVStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 120,
'name' => 'Salacgrīva Municipality',
'iso2' => '086'
],[
'country_id' => 120,
'name' => 'Vecumnieki Municipality',
'iso2' => '105'
],[
'country_id' => 120,
'name' => 'Naukšēni Municipality',
'iso2' => '064'
],[
'country_id' => 120,
'name' => 'Ilūkste Municipality',
'iso2' => '036'
],[
'country_id' => 120,
'name' => 'Gulbene Municipality',
'iso2' => '033'
],[
'country_id' => 120,
'name' => 'Līvāni Municipality',
'iso2' => '056'
],[
'country_id' => 120,
'name' => 'Salaspils Municipality',
'iso2' => '087'
],[
'country_id' => 120,
'name' => 'Ventspils Municipality',
'iso2' => '106'
],[
'country_id' => 120,
'name' => 'Rundāle Municipality',
'iso2' => '083'
],[
'country_id' => 120,
'name' => 'Pļaviņas Municipality',
'iso2' => '072'
],[
'country_id' => 120,
'name' => 'Vārkava Municipality',
'iso2' => '103'
],[
'country_id' => 120,
'name' => 'Jaunpiebalga Municipality',
'iso2' => '039'
],[
'country_id' => 120,
'name' => 'Sēja Municipality',
'iso2' => '090'
],[
'country_id' => 120,
'name' => 'Tukums Municipality',
'iso2' => '099'
],[
'country_id' => 120,
'name' => 'Cibla Municipality',
'iso2' => '023'
],[
'country_id' => 120,
'name' => 'Burtnieki Municipality',
'iso2' => '019'
],[
'country_id' => 120,
'name' => 'Ķegums Municipality',
'iso2' => '051'
],[
'country_id' => 120,
'name' => 'Krustpils Municipality',
'iso2' => '049'
],[
'country_id' => 120,
'name' => 'Cesvaine Municipality',
'iso2' => '021'
],[
'country_id' => 120,
'name' => 'Skrīveri Municipality',
'iso2' => '092'
],[
'country_id' => 120,
'name' => 'Ogre Municipality',
'iso2' => '067'
],[
'country_id' => 120,
'name' => 'Olaine Municipality',
'iso2' => '068'
],[
'country_id' => 120,
'name' => 'Limbaži Municipality',
'iso2' => '054'
],[
'country_id' => 120,
'name' => 'Lubāna Municipality',
'iso2' => '057'
],[
'country_id' => 120,
'name' => 'Kandava Municipality',
'iso2' => '043'
],[
'country_id' => 120,
'name' => 'Ventspils',
'iso2' => 'VEN'
],[
'country_id' => 120,
'name' => 'Krimulda Municipality',
'iso2' => '048'
],[
'country_id' => 120,
'name' => 'Rugāji Municipality',
'iso2' => '082'
],[
'country_id' => 120,
'name' => 'Jelgava Municipality',
'iso2' => '041'
],[
'country_id' => 120,
'name' => 'Valka Municipality',
'iso2' => '101'
],[
'country_id' => 120,
'name' => 'Rūjiena Municipality',
'iso2' => '084'
],[
'country_id' => 120,
'name' => 'Babīte Municipality',
'iso2' => '012'
],[
'country_id' => 120,
'name' => 'Dundaga Municipality',
'iso2' => '027'
],[
'country_id' => 120,
'name' => 'Priekule Municipality',
'iso2' => '074'
],[
'country_id' => 120,
'name' => 'Zilupe Municipality',
'iso2' => '110'
],[
'country_id' => 120,
'name' => 'Varakļāni Municipality',
'iso2' => '102'
],[
'country_id' => 120,
'name' => 'Nereta Municipality',
'iso2' => '065'
],[
'country_id' => 120,
'name' => 'Madona Municipality',
'iso2' => '059'
],[
'country_id' => 120,
'name' => 'Sala Municipality',
'iso2' => '085'
],[
'country_id' => 120,
'name' => 'Ķekava Municipality',
'iso2' => '052'
],[
'country_id' => 120,
'name' => 'Nīca Municipality',
'iso2' => '066'
],[
'country_id' => 120,
'name' => 'Dobele Municipality',
'iso2' => '026'
],[
'country_id' => 120,
'name' => 'Jēkabpils Municipality',
'iso2' => '042'
],[
'country_id' => 120,
'name' => 'Saldus Municipality',
'iso2' => '088'
],[
'country_id' => 120,
'name' => 'Roja Municipality',
'iso2' => '079'
],[
'country_id' => 120,
'name' => 'Iecava Municipality',
'iso2' => '034'
],[
'country_id' => 120,
'name' => 'Ozolnieki Municipality',
'iso2' => '069'
],[
'country_id' => 120,
'name' => 'Saulkrasti Municipality',
'iso2' => '089'
],[
'country_id' => 120,
'name' => 'Ērgļi Municipality',
'iso2' => '030'
],[
'country_id' => 120,
'name' => 'Aglona Municipality',
'iso2' => '001'
],[
'country_id' => 120,
'name' => 'Jūrmala',
'iso2' => 'JUR'
],[
'country_id' => 120,
'name' => 'Skrunda Municipality',
'iso2' => '093'
],[
'country_id' => 120,
'name' => 'Engure Municipality',
'iso2' => '029'
],[
'country_id' => 120,
'name' => 'Inčukalns Municipality',
'iso2' => '037'
],[
'country_id' => 120,
'name' => 'Mārupe Municipality',
'iso2' => '062'
],[
'country_id' => 120,
'name' => 'Mērsrags Municipality',
'iso2' => '063'
],[
'country_id' => 120,
'name' => 'Koknese Municipality',
'iso2' => '046'
],[
'country_id' => 120,
'name' => 'Kārsava Municipality',
'iso2' => '044'
],[
'country_id' => 120,
'name' => 'Carnikava Municipality',
'iso2' => '020'
],[
'country_id' => 120,
'name' => 'Rēzekne Municipality',
'iso2' => '077'
],[
'country_id' => 120,
'name' => 'Viesīte Municipality',
'iso2' => '107'
],[
'country_id' => 120,
'name' => 'Ape Municipality',
'iso2' => '009'
],[
'country_id' => 120,
'name' => 'Durbe Municipality',
'iso2' => '028'
],[
'country_id' => 120,
'name' => 'Talsi Municipality',
'iso2' => '097'
],[
'country_id' => 120,
'name' => 'Liepāja',
'iso2' => 'LPX'
],[
'country_id' => 120,
'name' => 'Mālpils Municipality',
'iso2' => '061'
],[
'country_id' => 120,
'name' => 'Smiltene Municipality',
'iso2' => '094'
],[
'country_id' => 120,
'name' => 'Daugavpils',
'iso2' => 'DGV'
],[
'country_id' => 120,
'name' => 'Jēkabpils',
'iso2' => 'JKB'
],[
'country_id' => 120,
'name' => 'Bauska Municipality',
'iso2' => '016'
],[
'country_id' => 120,
'name' => 'Vecpiebalga Municipality',
'iso2' => '104'
],[
'country_id' => 120,
'name' => 'Pāvilosta Municipality',
'iso2' => '071'
],[
'country_id' => 120,
'name' => 'Brocēni Municipality',
'iso2' => '018'
],[
'country_id' => 120,
'name' => 'Cēsis Municipality',
'iso2' => '022'
],[
'country_id' => 120,
'name' => 'Grobiņa Municipality',
'iso2' => '032'
],[
'country_id' => 120,
'name' => 'Beverīna Municipality',
'iso2' => '017'
],[
'country_id' => 120,
'name' => 'Aizkraukle Municipality',
'iso2' => '002'
],[
'country_id' => 120,
'name' => 'Valmiera',
'iso2' => 'VMR'
],[
'country_id' => 120,
'name' => 'Krāslava Municipality',
'iso2' => '047'
],[
'country_id' => 120,
'name' => 'Jaunjelgava Municipality',
'iso2' => '038'
],[
'country_id' => 120,
'name' => 'Sigulda Municipality',
'iso2' => '091'
],[
'country_id' => 120,
'name' => 'Viļaka Municipality',
'iso2' => '108'
],[
'country_id' => 120,
'name' => 'Stopiņi Municipality',
'iso2' => '095'
],[
'country_id' => 120,
'name' => 'Rauna Municipality',
'iso2' => '076'
],[
'country_id' => 120,
'name' => 'Tērvete Municipality',
'iso2' => '098'
],[
'country_id' => 120,
'name' => 'Auce Municipality',
'iso2' => '010'
],[
'country_id' => 120,
'name' => 'Baldone Municipality',
'iso2' => '013'
],[
'country_id' => 120,
'name' => 'Preiļi Municipality',
'iso2' => '073'
],[
'country_id' => 120,
'name' => 'Aloja Municipality',
'iso2' => '005'
],[
'country_id' => 120,
'name' => 'Alsunga Municipality',
'iso2' => '006'
],[
'country_id' => 120,
'name' => 'Viļāni Municipality',
'iso2' => '109'
],[
'country_id' => 120,
'name' => 'Alūksne Municipality',
'iso2' => '007'
],[
'country_id' => 120,
'name' => 'Līgatne Municipality',
'iso2' => '055'
],[
'country_id' => 120,
'name' => 'Jaunpils Municipality',
'iso2' => '040'
],[
'country_id' => 120,
'name' => 'Kuldīga Municipality',
'iso2' => '050'
],[
'country_id' => 120,
'name' => 'Riga',
'iso2' => 'RIX'
],[
'country_id' => 120,
'name' => 'Daugavpils Municipality',
'iso2' => '025'
],[
'country_id' => 120,
'name' => 'Ropaži Municipality',
'iso2' => '080'
],[
'country_id' => 120,
'name' => 'Strenči Municipality',
'iso2' => '096'
],[
'country_id' => 120,
'name' => 'Kocēni Municipality',
'iso2' => '045'
],[
'country_id' => 120,
'name' => 'Aizpute Municipality',
'iso2' => '003'
],[
'country_id' => 120,
'name' => 'Amata Municipality',
'iso2' => '008'
],[
'country_id' => 120,
'name' => 'Baltinava Municipality',
'iso2' => '014'
],[
'country_id' => 120,
'name' => 'Aknīste Municipality',
'iso2' => '004'
],[
'country_id' => 120,
'name' => 'Jelgava',
'iso2' => 'JEL'
],[
'country_id' => 120,
'name' => 'Ludza Municipality',
'iso2' => '058'
],[
'country_id' => 120,
'name' => 'Riebiņi Municipality',
'iso2' => '078'
],[
'country_id' => 120,
'name' => 'Rucava Municipality',
'iso2' => '081'
],[
'country_id' => 120,
'name' => 'Dagda Municipality',
'iso2' => '024'
],[
'country_id' => 120,
'name' => 'Balvi Municipality',
'iso2' => '015'
],[
'country_id' => 120,
'name' => 'Priekuļi Municipality',
'iso2' => '075'
],[
'country_id' => 120,
'name' => 'Pārgauja Municipality',
'iso2' => '070'
],[
'country_id' => 120,
'name' => 'Vaiņode Municipality',
'iso2' => '100'
],[
'country_id' => 120,
'name' => 'Rēzekne',
'iso2' => 'REZ'
],[
'country_id' => 120,
'name' => 'Garkalne Municipality',
'iso2' => '031'
],[
'country_id' => 120,
'name' => 'Ikšķile Municipality',
'iso2' => '035'
],[
'country_id' => 120,
'name' => 'Lielvārde Municipality',
'iso2' => '053'
],[
'country_id' => 120,
'name' => 'Mazsalaca Municipality',
'iso2' => '060'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
