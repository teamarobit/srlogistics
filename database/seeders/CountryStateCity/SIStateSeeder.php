<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class SIStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 201,
'name' => 'Braslovče Municipality',
'iso2' => '151'
],[
'country_id' => 201,
'name' => 'Lenart Municipality',
'iso2' => '058'
],[
'country_id' => 201,
'name' => 'Oplotnica',
'iso2' => '171'
],[
'country_id' => 201,
'name' => 'Velike Lašče Municipality',
'iso2' => '134'
],[
'country_id' => 201,
'name' => 'Hajdina Municipality',
'iso2' => '159'
],[
'country_id' => 201,
'name' => 'Podčetrtek Municipality',
'iso2' => '092'
],[
'country_id' => 201,
'name' => 'Cankova Municipality',
'iso2' => '152'
],[
'country_id' => 201,
'name' => 'Vitanje Municipality',
'iso2' => '137'
],[
'country_id' => 201,
'name' => 'Sežana Municipality',
'iso2' => '111'
],[
'country_id' => 201,
'name' => 'Kidričevo Municipality',
'iso2' => '045'
],[
'country_id' => 201,
'name' => 'Črenšovci Municipality',
'iso2' => '015'
],[
'country_id' => 201,
'name' => 'Idrija Municipality',
'iso2' => '036'
],[
'country_id' => 201,
'name' => 'Trnovska Vas Municipality',
'iso2' => '185'
],[
'country_id' => 201,
'name' => 'Vodice Municipality',
'iso2' => '138'
],[
'country_id' => 201,
'name' => 'Ravne na Koroškem Municipality',
'iso2' => '103'
],[
'country_id' => 201,
'name' => 'Lovrenc na Pohorju Municipality',
'iso2' => '167'
],[
'country_id' => 201,
'name' => 'Majšperk Municipality',
'iso2' => '069'
],[
'country_id' => 201,
'name' => 'Loški Potok Municipality',
'iso2' => '066'
],[
'country_id' => 201,
'name' => 'Domžale Municipality',
'iso2' => '023'
],[
'country_id' => 201,
'name' => 'Rečica ob Savinji Municipality',
'iso2' => '209'
],[
'country_id' => 201,
'name' => 'Podlehnik Municipality',
'iso2' => '172'
],[
'country_id' => 201,
'name' => 'Cerknica Municipality',
'iso2' => '013'
],[
'country_id' => 201,
'name' => 'Vransko Municipality',
'iso2' => '189'
],[
'country_id' => 201,
'name' => 'Sveta Ana Municipality',
'iso2' => '181'
],[
'country_id' => 201,
'name' => 'Brezovica Municipality',
'iso2' => '008'
],[
'country_id' => 201,
'name' => 'Benedikt Municipality',
'iso2' => '148'
],[
'country_id' => 201,
'name' => 'Divača Municipality',
'iso2' => '019'
],[
'country_id' => 201,
'name' => 'Moravče Municipality',
'iso2' => '077'
],[
'country_id' => 201,
'name' => 'Slovenj Gradec City Municipality',
'iso2' => '112'
],[
'country_id' => 201,
'name' => 'Škocjan Municipality',
'iso2' => '121'
],[
'country_id' => 201,
'name' => 'Šentjur Municipality',
'iso2' => '120'
],[
'country_id' => 201,
'name' => 'Pesnica Municipality',
'iso2' => '089'
],[
'country_id' => 201,
'name' => 'Dol pri Ljubljani Municipality',
'iso2' => '022'
],[
'country_id' => 201,
'name' => 'Loška Dolina Municipality',
'iso2' => '065'
],[
'country_id' => 201,
'name' => 'Hoče–Slivnica Municipality',
'iso2' => '160'
],[
'country_id' => 201,
'name' => 'Cerkvenjak Municipality',
'iso2' => '153'
],[
'country_id' => 201,
'name' => 'Naklo Municipality',
'iso2' => '082'
],[
'country_id' => 201,
'name' => 'Cerkno Municipality',
'iso2' => '014'
],[
'country_id' => 201,
'name' => 'Bistrica ob Sotli Municipality',
'iso2' => '149'
],[
'country_id' => 201,
'name' => 'Kamnik Municipality',
'iso2' => '043'
],[
'country_id' => 201,
'name' => 'Bovec Municipality',
'iso2' => '006'
],[
'country_id' => 201,
'name' => 'Zavrč Municipality',
'iso2' => '143'
],[
'country_id' => 201,
'name' => 'Ajdovščina Municipality',
'iso2' => '001'
],[
'country_id' => 201,
'name' => 'Pivka Municipality',
'iso2' => '091'
],[
'country_id' => 201,
'name' => 'Štore Municipality',
'iso2' => '127'
],[
'country_id' => 201,
'name' => 'Kozje Municipality',
'iso2' => '051'
],[
'country_id' => 201,
'name' => 'Municipality of Škofljica',
'iso2' => '123'
],[
'country_id' => 201,
'name' => 'Prebold Municipality',
'iso2' => '174'
],[
'country_id' => 201,
'name' => 'Dobrovnik Municipality',
'iso2' => '156'
],[
'country_id' => 201,
'name' => 'Mozirje Municipality',
'iso2' => '079'
],[
'country_id' => 201,
'name' => 'City Municipality of Celje',
'iso2' => '011'
],[
'country_id' => 201,
'name' => 'Žiri Municipality',
'iso2' => '147'
],[
'country_id' => 201,
'name' => 'Horjul Municipality',
'iso2' => '162'
],[
'country_id' => 201,
'name' => 'Tabor Municipality',
'iso2' => '184'
],[
'country_id' => 201,
'name' => 'Radeče Municipality',
'iso2' => '099'
],[
'country_id' => 201,
'name' => 'Vipava Municipality',
'iso2' => '136'
],[
'country_id' => 201,
'name' => 'Kungota',
'iso2' => '055'
],[
'country_id' => 201,
'name' => 'Slovenske Konjice Municipality',
'iso2' => '114'
],[
'country_id' => 201,
'name' => 'Osilnica Municipality',
'iso2' => '088'
],[
'country_id' => 201,
'name' => 'Borovnica Municipality',
'iso2' => '005'
],[
'country_id' => 201,
'name' => 'Piran Municipality',
'iso2' => '090'
],[
'country_id' => 201,
'name' => 'Bled Municipality',
'iso2' => '003'
],[
'country_id' => 201,
'name' => 'Jezersko Municipality',
'iso2' => '163'
],[
'country_id' => 201,
'name' => 'Rače–Fram Municipality',
'iso2' => '098'
],[
'country_id' => 201,
'name' => 'Nova Gorica City Municipality',
'iso2' => '084'
],[
'country_id' => 201,
'name' => 'Razkrižje Municipality',
'iso2' => '176'
],[
'country_id' => 201,
'name' => 'Ribnica na Pohorju Municipality',
'iso2' => '177'
],[
'country_id' => 201,
'name' => 'Muta Municipality',
'iso2' => '081'
],[
'country_id' => 201,
'name' => 'Rogatec Municipality',
'iso2' => '107'
],[
'country_id' => 201,
'name' => 'Gorišnica Municipality',
'iso2' => '028'
],[
'country_id' => 201,
'name' => 'Kuzma Municipality',
'iso2' => '056'
],[
'country_id' => 201,
'name' => 'Mislinja Municipality',
'iso2' => '076'
],[
'country_id' => 201,
'name' => 'Duplek Municipality',
'iso2' => '026'
],[
'country_id' => 201,
'name' => 'Trebnje Municipality',
'iso2' => '130'
],[
'country_id' => 201,
'name' => 'Brežice Municipality',
'iso2' => '009'
],[
'country_id' => 201,
'name' => 'Dobrepolje Municipality',
'iso2' => '020'
],[
'country_id' => 201,
'name' => 'Grad Municipality',
'iso2' => '158'
],[
'country_id' => 201,
'name' => 'Moravske Toplice Municipality',
'iso2' => '078'
],[
'country_id' => 201,
'name' => 'Luče Municipality',
'iso2' => '067'
],[
'country_id' => 201,
'name' => 'Miren–Kostanjevica Municipality',
'iso2' => '075'
],[
'country_id' => 201,
'name' => 'Ormož Municipality',
'iso2' => '087'
],[
'country_id' => 201,
'name' => 'Šalovci Municipality',
'iso2' => '033'
],[
'country_id' => 201,
'name' => 'Miklavž na Dravskem Polju Municipality',
'iso2' => '169'
],[
'country_id' => 201,
'name' => 'Makole Municipality',
'iso2' => '198'
],[
'country_id' => 201,
'name' => 'Lendava Municipality',
'iso2' => '059'
],[
'country_id' => 201,
'name' => 'Vuzenica Municipality',
'iso2' => '141'
],[
'country_id' => 201,
'name' => 'Kanal ob Soči Municipality',
'iso2' => '044'
],[
'country_id' => 201,
'name' => 'Ptuj City Municipality',
'iso2' => '096'
],[
'country_id' => 201,
'name' => 'Sveti Andraž v Slovenskih Goricah Municipality',
'iso2' => '182'
],[
'country_id' => 201,
'name' => 'Selnica ob Dravi Municipality',
'iso2' => '178'
],[
'country_id' => 201,
'name' => 'Radovljica Municipality',
'iso2' => '102'
],[
'country_id' => 201,
'name' => 'Črna na Koroškem Municipality',
'iso2' => '016'
],[
'country_id' => 201,
'name' => 'Rogaška Slatina Municipality',
'iso2' => '106'
],[
'country_id' => 201,
'name' => 'Podvelka Municipality',
'iso2' => '093'
],[
'country_id' => 201,
'name' => 'Ribnica Municipality',
'iso2' => '104'
],[
'country_id' => 201,
'name' => 'City Municipality of Novo Mesto',
'iso2' => '085'
],[
'country_id' => 201,
'name' => 'Mirna Peč Municipality',
'iso2' => '170'
],[
'country_id' => 201,
'name' => 'Križevci Municipality',
'iso2' => '166'
],[
'country_id' => 201,
'name' => 'Poljčane Municipality',
'iso2' => '200'
],[
'country_id' => 201,
'name' => 'Brda Municipality',
'iso2' => '007'
],[
'country_id' => 201,
'name' => 'Šentjernej Municipality',
'iso2' => '119'
],[
'country_id' => 201,
'name' => 'Maribor City Municipality',
'iso2' => '070'
],[
'country_id' => 201,
'name' => 'Kobarid Municipality',
'iso2' => '046'
],[
'country_id' => 201,
'name' => 'Markovci Municipality',
'iso2' => '168'
],[
'country_id' => 201,
'name' => 'Vojnik Municipality',
'iso2' => '139'
],[
'country_id' => 201,
'name' => 'Trbovlje Municipality',
'iso2' => '129'
],[
'country_id' => 201,
'name' => 'Tolmin Municipality',
'iso2' => '128'
],[
'country_id' => 201,
'name' => 'Šoštanj Municipality',
'iso2' => '126'
],[
'country_id' => 201,
'name' => 'Žetale Municipality',
'iso2' => '191'
],[
'country_id' => 201,
'name' => 'Tržič Municipality',
'iso2' => '131'
],[
'country_id' => 201,
'name' => 'Turnišče Municipality',
'iso2' => '132'
],[
'country_id' => 201,
'name' => 'Dobrna Municipality',
'iso2' => '155'
],[
'country_id' => 201,
'name' => 'Renče–Vogrsko Municipality',
'iso2' => '201'
],[
'country_id' => 201,
'name' => 'Kostanjevica na Krki Municipality',
'iso2' => '197'
],[
'country_id' => 201,
'name' => 'Sveti Jurij ob Ščavnici Municipality',
'iso2' => '116'
],[
'country_id' => 201,
'name' => 'Železniki Municipality',
'iso2' => '146'
],[
'country_id' => 201,
'name' => 'Veržej Municipality',
'iso2' => '188'
],[
'country_id' => 201,
'name' => 'Žalec Municipality',
'iso2' => '190'
],[
'country_id' => 201,
'name' => 'Starše Municipality',
'iso2' => '115'
],[
'country_id' => 201,
'name' => 'Sveta Trojica v Slovenskih Goricah Municipality',
'iso2' => '204'
],[
'country_id' => 201,
'name' => 'Solčava Municipality',
'iso2' => '180'
],[
'country_id' => 201,
'name' => 'Vrhnika Municipality',
'iso2' => '140'
],[
'country_id' => 201,
'name' => 'Središče ob Dravi',
'iso2' => '202'
],[
'country_id' => 201,
'name' => 'Rogašovci Municipality',
'iso2' => '105'
],[
'country_id' => 201,
'name' => 'Mežica Municipality',
'iso2' => '074'
],[
'country_id' => 201,
'name' => 'Juršinci Municipality',
'iso2' => '042'
],[
'country_id' => 201,
'name' => 'Velika Polana Municipality',
'iso2' => '187'
],[
'country_id' => 201,
'name' => 'Sevnica Municipality',
'iso2' => '110'
],[
'country_id' => 201,
'name' => 'Zagorje ob Savi Municipality',
'iso2' => '142'
],[
'country_id' => 201,
'name' => 'Ljubljana City Municipality',
'iso2' => '061'
],[
'country_id' => 201,
'name' => 'Gornji Petrovci Municipality',
'iso2' => '031'
],[
'country_id' => 201,
'name' => 'Polzela Municipality',
'iso2' => '173'
],[
'country_id' => 201,
'name' => 'Sveti Tomaž Municipality',
'iso2' => '205'
],[
'country_id' => 201,
'name' => 'Prevalje Municipality',
'iso2' => '175'
],[
'country_id' => 201,
'name' => 'Radlje ob Dravi Municipality',
'iso2' => '101'
],[
'country_id' => 201,
'name' => 'Žirovnica Municipality',
'iso2' => '192'
],[
'country_id' => 201,
'name' => 'Sodražica Municipality',
'iso2' => '179'
],[
'country_id' => 201,
'name' => 'Bloke Municipality',
'iso2' => '150'
],[
'country_id' => 201,
'name' => 'Šmartno pri Litiji Municipality',
'iso2' => '194'
],[
'country_id' => 201,
'name' => 'Ruše Municipality',
'iso2' => '108'
],[
'country_id' => 201,
'name' => 'Dolenjske Toplice Municipality',
'iso2' => '157'
],[
'country_id' => 201,
'name' => 'Bohinj Municipality',
'iso2' => '004'
],[
'country_id' => 201,
'name' => 'Komenda Municipality',
'iso2' => '164'
],[
'country_id' => 201,
'name' => 'Gorje Municipality',
'iso2' => '207'
],[
'country_id' => 201,
'name' => 'Šmarje pri Jelšah Municipality',
'iso2' => '124'
],[
'country_id' => 201,
'name' => 'Ig Municipality',
'iso2' => '037'
],[
'country_id' => 201,
'name' => 'Kranj City Municipality',
'iso2' => '052'
],[
'country_id' => 201,
'name' => 'Puconci Municipality',
'iso2' => '097'
],[
'country_id' => 201,
'name' => 'Šmarješke Toplice Municipality',
'iso2' => '206'
],[
'country_id' => 201,
'name' => 'Dornava Municipality',
'iso2' => '024'
],[
'country_id' => 201,
'name' => 'Črnomelj Municipality',
'iso2' => '017'
],[
'country_id' => 201,
'name' => 'Radenci Municipality',
'iso2' => '100'
],[
'country_id' => 201,
'name' => 'Gorenja Vas–Poljane Municipality',
'iso2' => '027'
],[
'country_id' => 201,
'name' => 'Ljubno Municipality',
'iso2' => '062'
],[
'country_id' => 201,
'name' => 'Dobje Municipality',
'iso2' => '154'
],[
'country_id' => 201,
'name' => 'Šmartno ob Paki Municipality',
'iso2' => '125'
],[
'country_id' => 201,
'name' => 'Mokronog–Trebelno Municipality',
'iso2' => '199'
],[
'country_id' => 201,
'name' => 'Mirna Municipality',
'iso2' => '212'
],[
'country_id' => 201,
'name' => 'Šenčur Municipality',
'iso2' => '117'
],[
'country_id' => 201,
'name' => 'Videm Municipality',
'iso2' => '135'
],[
'country_id' => 201,
'name' => 'Beltinci Municipality',
'iso2' => '002'
],[
'country_id' => 201,
'name' => 'Lukovica Municipality',
'iso2' => '068'
],[
'country_id' => 201,
'name' => 'Preddvor Municipality',
'iso2' => '095'
],[
'country_id' => 201,
'name' => 'Destrnik Municipality',
'iso2' => '018'
],[
'country_id' => 201,
'name' => 'Ivančna Gorica Municipality',
'iso2' => '039'
],[
'country_id' => 201,
'name' => 'Log–Dragomer Municipality',
'iso2' => '208'
],[
'country_id' => 201,
'name' => 'Žužemberk Municipality',
'iso2' => '193'
],[
'country_id' => 201,
'name' => 'Dobrova–Polhov Gradec Municipality',
'iso2' => '021'
],[
'country_id' => 201,
'name' => 'Municipality of Cirkulane',
'iso2' => '196'
],[
'country_id' => 201,
'name' => 'Cerklje na Gorenjskem Municipality',
'iso2' => '012'
],[
'country_id' => 201,
'name' => 'Šentrupert Municipality',
'iso2' => '211'
],[
'country_id' => 201,
'name' => 'Tišina Municipality',
'iso2' => '010'
],[
'country_id' => 201,
'name' => 'Murska Sobota City Municipality',
'iso2' => '080'
],[
'country_id' => 201,
'name' => 'Municipality of Krško',
'iso2' => '054'
],[
'country_id' => 201,
'name' => 'Komen Municipality',
'iso2' => '049'
],[
'country_id' => 201,
'name' => 'Škofja Loka Municipality',
'iso2' => '122'
],[
'country_id' => 201,
'name' => 'Šempeter–Vrtojba Municipality',
'iso2' => '183'
],[
'country_id' => 201,
'name' => 'Municipality of Apače',
'iso2' => '195'
],[
'country_id' => 201,
'name' => 'Koper City Municipality',
'iso2' => '050'
],[
'country_id' => 201,
'name' => 'Odranci Municipality',
'iso2' => '086'
],[
'country_id' => 201,
'name' => 'Hrpelje–Kozina Municipality',
'iso2' => '035'
],[
'country_id' => 201,
'name' => 'Izola Municipality',
'iso2' => '040'
],[
'country_id' => 201,
'name' => 'Metlika Municipality',
'iso2' => '073'
],[
'country_id' => 201,
'name' => 'Šentilj Municipality',
'iso2' => '118'
],[
'country_id' => 201,
'name' => 'Kobilje Municipality',
'iso2' => '047'
],[
'country_id' => 201,
'name' => 'Ankaran Municipality',
'iso2' => '213'
],[
'country_id' => 201,
'name' => 'Hodoš Municipality',
'iso2' => '161'
],[
'country_id' => 201,
'name' => 'Sveti Jurij v Slovenskih Goricah Municipality',
'iso2' => '210'
],[
'country_id' => 201,
'name' => 'Nazarje Municipality',
'iso2' => '083'
],[
'country_id' => 201,
'name' => 'Postojna Municipality',
'iso2' => '094'
],[
'country_id' => 201,
'name' => 'Kostel Municipality',
'iso2' => '165'
],[
'country_id' => 201,
'name' => 'Slovenska Bistrica Municipality',
'iso2' => '113'
],[
'country_id' => 201,
'name' => 'Straža Municipality',
'iso2' => '203'
],[
'country_id' => 201,
'name' => 'Trzin Municipality',
'iso2' => '186'
],[
'country_id' => 201,
'name' => 'Kočevje Municipality',
'iso2' => '048'
],[
'country_id' => 201,
'name' => 'Grosuplje Municipality',
'iso2' => '032'
],[
'country_id' => 201,
'name' => 'Jesenice Municipality',
'iso2' => '041'
],[
'country_id' => 201,
'name' => 'Laško Municipality',
'iso2' => '057'
],[
'country_id' => 201,
'name' => 'Gornji Grad Municipality',
'iso2' => '030'
],[
'country_id' => 201,
'name' => 'Kranjska Gora Municipality',
'iso2' => '053'
],[
'country_id' => 201,
'name' => 'Hrastnik Municipality',
'iso2' => '034'
],[
'country_id' => 201,
'name' => 'Zreče Municipality',
'iso2' => '144'
],[
'country_id' => 201,
'name' => 'Gornja Radgona Municipality',
'iso2' => '029'
],[
'country_id' => 201,
'name' => 'Municipality of Ilirska Bistrica',
'iso2' => '038'
],[
'country_id' => 201,
'name' => 'Dravograd Municipality',
'iso2' => '025'
],[
'country_id' => 201,
'name' => 'Semič Municipality',
'iso2' => '109'
],[
'country_id' => 201,
'name' => 'Litija Municipality',
'iso2' => '060'
],[
'country_id' => 201,
'name' => 'Mengeš Municipality',
'iso2' => '072'
],[
'country_id' => 201,
'name' => 'Medvode Municipality',
'iso2' => '071'
],[
'country_id' => 201,
'name' => 'Logatec Municipality',
'iso2' => '064'
],[
'country_id' => 201,
'name' => 'Ljutomer Municipality',
'iso2' => '063'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
