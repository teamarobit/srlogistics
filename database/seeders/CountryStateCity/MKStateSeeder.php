<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class MKStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 129,
'name' => 'Sveti Nikole Municipality',
'iso2' => '69'
],[
'country_id' => 129,
'name' => 'Kratovo Municipality',
'iso2' => '43'
],[
'country_id' => 129,
'name' => 'Zajas Municipality',
'iso2' => '31'
],[
'country_id' => 129,
'name' => 'Staro Nagoričane Municipality',
'iso2' => '71'
],[
'country_id' => 129,
'name' => 'Češinovo-Obleševo Municipality',
'iso2' => '81'
],[
'country_id' => 129,
'name' => 'Debarca Municipality',
'iso2' => '22'
],[
'country_id' => 129,
'name' => 'Probištip Municipality',
'iso2' => '63'
],[
'country_id' => 129,
'name' => 'Krivogaštani Municipality',
'iso2' => '45'
],[
'country_id' => 129,
'name' => 'Gevgelija Municipality',
'iso2' => '18'
],[
'country_id' => 129,
'name' => 'Bogdanci Municipality',
'iso2' => '05'
],[
'country_id' => 129,
'name' => 'Vraneštica Municipality',
'iso2' => '15'
],[
'country_id' => 129,
'name' => 'Veles Municipality',
'iso2' => '13'
],[
'country_id' => 129,
'name' => 'Bosilovo Municipality',
'iso2' => '07'
],[
'country_id' => 129,
'name' => 'Mogila Municipality',
'iso2' => '53'
],[
'country_id' => 129,
'name' => 'Tearce Municipality',
'iso2' => '75'
],[
'country_id' => 129,
'name' => 'Demir Kapija Municipality',
'iso2' => '24'
],[
'country_id' => 129,
'name' => 'Aračinovo Municipality',
'iso2' => '02'
],[
'country_id' => 129,
'name' => 'Drugovo Municipality',
'iso2' => '28'
],[
'country_id' => 129,
'name' => 'Vasilevo Municipality',
'iso2' => '11'
],[
'country_id' => 129,
'name' => 'Lipkovo Municipality',
'iso2' => '48'
],[
'country_id' => 129,
'name' => 'Brvenica Municipality',
'iso2' => '08'
],[
'country_id' => 129,
'name' => 'Štip Municipality',
'iso2' => '83'
],[
'country_id' => 129,
'name' => 'Vevčani Municipality',
'iso2' => '12'
],[
'country_id' => 129,
'name' => 'Tetovo Municipality',
'iso2' => '76'
],[
'country_id' => 129,
'name' => 'Negotino Municipality',
'iso2' => '54'
],[
'country_id' => 129,
'name' => 'Konče Municipality',
'iso2' => '41'
],[
'country_id' => 129,
'name' => 'Prilep Municipality',
'iso2' => '62'
],[
'country_id' => 129,
'name' => 'Saraj Municipality',
'iso2' => '68'
],[
'country_id' => 129,
'name' => 'Želino Municipality',
'iso2' => '30'
],[
'country_id' => 129,
'name' => 'Mavrovo and Rostuša Municipality',
'iso2' => '50'
],[
'country_id' => 129,
'name' => 'Plasnica Municipality',
'iso2' => '61'
],[
'country_id' => 129,
'name' => 'Valandovo Municipality',
'iso2' => '10'
],[
'country_id' => 129,
'name' => 'Vinica Municipality',
'iso2' => '14'
],[
'country_id' => 129,
'name' => 'Zrnovci Municipality',
'iso2' => '33'
],[
'country_id' => 129,
'name' => 'Karbinci',
'iso2' => '37'
],[
'country_id' => 129,
'name' => 'Dolneni Municipality',
'iso2' => '27'
],[
'country_id' => 129,
'name' => 'Čaška Municipality',
'iso2' => '80'
],[
'country_id' => 129,
'name' => 'Kriva Palanka Municipality',
'iso2' => '44'
],[
'country_id' => 129,
'name' => 'Jegunovce Municipality',
'iso2' => '35'
],[
'country_id' => 129,
'name' => 'Bitola Municipality',
'iso2' => '04'
],[
'country_id' => 129,
'name' => 'Šuto Orizari Municipality',
'iso2' => '84'
],[
'country_id' => 129,
'name' => 'Karpoš Municipality',
'iso2' => '38'
],[
'country_id' => 129,
'name' => 'Oslomej Municipality',
'iso2' => '57'
],[
'country_id' => 129,
'name' => 'Kumanovo Municipality',
'iso2' => '47'
],[
'country_id' => 129,
'name' => 'Greater Skopje',
'iso2' => '85'
],[
'country_id' => 129,
'name' => 'Pehčevo Municipality',
'iso2' => '60'
],[
'country_id' => 129,
'name' => 'Kisela Voda Municipality',
'iso2' => '39'
],[
'country_id' => 129,
'name' => 'Demir Hisar Municipality',
'iso2' => '25'
],[
'country_id' => 129,
'name' => 'Kičevo Municipality',
'iso2' => '40'
],[
'country_id' => 129,
'name' => 'Vrapčište Municipality',
'iso2' => '16'
],[
'country_id' => 129,
'name' => 'Ilinden Municipality',
'iso2' => '34'
],[
'country_id' => 129,
'name' => 'Rosoman Municipality',
'iso2' => '67'
],[
'country_id' => 129,
'name' => 'Makedonski Brod Municipality',
'iso2' => '52'
],[
'country_id' => 129,
'name' => 'Gostivar Municipality',
'iso2' => '19'
],[
'country_id' => 129,
'name' => 'Butel Municipality',
'iso2' => '09'
],[
'country_id' => 129,
'name' => 'Delčevo Municipality',
'iso2' => '23'
],[
'country_id' => 129,
'name' => 'Novaci Municipality',
'iso2' => '55'
],[
'country_id' => 129,
'name' => 'Dojran Municipality',
'iso2' => '26'
],[
'country_id' => 129,
'name' => 'Petrovec Municipality',
'iso2' => '59'
],[
'country_id' => 129,
'name' => 'Ohrid Municipality',
'iso2' => '58'
],[
'country_id' => 129,
'name' => 'Struga Municipality',
'iso2' => '72'
],[
'country_id' => 129,
'name' => 'Makedonska Kamenica Municipality',
'iso2' => '51'
],[
'country_id' => 129,
'name' => 'Centar Municipality',
'iso2' => '77'
],[
'country_id' => 129,
'name' => 'Aerodrom Municipality',
'iso2' => '01'
],[
'country_id' => 129,
'name' => 'Čair Municipality',
'iso2' => '79'
],[
'country_id' => 129,
'name' => 'Lozovo Municipality',
'iso2' => '49'
],[
'country_id' => 129,
'name' => 'Zelenikovo Municipality',
'iso2' => '32'
],[
'country_id' => 129,
'name' => 'Gazi Baba Municipality',
'iso2' => '17'
],[
'country_id' => 129,
'name' => 'Gradsko Municipality',
'iso2' => '20'
],[
'country_id' => 129,
'name' => 'Radoviš Municipality',
'iso2' => '64'
],[
'country_id' => 129,
'name' => 'Strumica Municipality',
'iso2' => '73'
],[
'country_id' => 129,
'name' => 'Studeničani Municipality',
'iso2' => '74'
],[
'country_id' => 129,
'name' => 'Resen Municipality',
'iso2' => '66'
],[
'country_id' => 129,
'name' => 'Kavadarci Municipality',
'iso2' => '36'
],[
'country_id' => 129,
'name' => 'Kruševo Municipality',
'iso2' => '46'
],[
'country_id' => 129,
'name' => 'Čučer-Sandevo Municipality',
'iso2' => '82'
],[
'country_id' => 129,
'name' => 'Berovo Municipality',
'iso2' => '03'
],[
'country_id' => 129,
'name' => 'Rankovce Municipality',
'iso2' => '65'
],[
'country_id' => 129,
'name' => 'Novo Selo Municipality',
'iso2' => '56'
],[
'country_id' => 129,
'name' => 'Sopište Municipality',
'iso2' => '70'
],[
'country_id' => 129,
'name' => 'Centar Župa Municipality',
'iso2' => '78'
],[
'country_id' => 129,
'name' => 'Bogovinje Municipality',
'iso2' => '06'
],[
'country_id' => 129,
'name' => 'Gjorče Petrov Municipality',
'iso2' => '29'
],[
'country_id' => 129,
'name' => 'Kočani Municipality',
'iso2' => '42'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
