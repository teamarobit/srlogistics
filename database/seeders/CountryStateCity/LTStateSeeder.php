<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class LTStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 126,
'name' => 'Plungė District Municipality',
'iso2' => '35'
],[
'country_id' => 126,
'name' => 'Šiauliai District Municipality',
'iso2' => '44'
],[
'country_id' => 126,
'name' => 'Jurbarkas District Municipality',
'iso2' => '12'
],[
'country_id' => 126,
'name' => 'Kaunas County',
'iso2' => 'KU'
],[
'country_id' => 126,
'name' => 'Mažeikiai District Municipality',
'iso2' => '26'
],[
'country_id' => 126,
'name' => 'Panevėžys County',
'iso2' => 'PN'
],[
'country_id' => 126,
'name' => 'Elektrėnai municipality',
'iso2' => '08'
],[
'country_id' => 126,
'name' => 'Švenčionys District Municipality',
'iso2' => '49'
],[
'country_id' => 126,
'name' => 'Akmenė District Municipality',
'iso2' => '01'
],[
'country_id' => 126,
'name' => 'Ignalina District Municipality',
'iso2' => '09'
],[
'country_id' => 126,
'name' => 'Neringa Municipality',
'iso2' => '28'
],[
'country_id' => 126,
'name' => 'Visaginas Municipality',
'iso2' => '59'
],[
'country_id' => 126,
'name' => 'Kaunas District Municipality',
'iso2' => '16'
],[
'country_id' => 126,
'name' => 'Biržai District Municipality',
'iso2' => '06'
],[
'country_id' => 126,
'name' => 'Jonava District Municipality',
'iso2' => '10'
],[
'country_id' => 126,
'name' => 'Radviliškis District Municipality',
'iso2' => '37'
],[
'country_id' => 126,
'name' => 'Telšiai County',
'iso2' => 'TE'
],[
'country_id' => 126,
'name' => 'Marijampolė County',
'iso2' => 'MR'
],[
'country_id' => 126,
'name' => 'Kretinga District Municipality',
'iso2' => '22'
],[
'country_id' => 126,
'name' => 'Tauragė District Municipality',
'iso2' => '50'
],[
'country_id' => 126,
'name' => 'Tauragė County',
'iso2' => 'TA'
],[
'country_id' => 126,
'name' => 'Alytus County',
'iso2' => 'AL'
],[
'country_id' => 126,
'name' => 'Kazlų Rūda municipality',
'iso2' => '17'
],[
'country_id' => 126,
'name' => 'Šakiai District Municipality',
'iso2' => '41'
],[
'country_id' => 126,
'name' => 'Šalčininkai District Municipality',
'iso2' => '42'
],[
'country_id' => 126,
'name' => 'Prienai District Municipality',
'iso2' => '36'
],[
'country_id' => 126,
'name' => 'Druskininkai municipality',
'iso2' => '07'
],[
'country_id' => 126,
'name' => 'Kaunas City Municipality',
'iso2' => '15'
],[
'country_id' => 126,
'name' => 'Joniškis District Municipality',
'iso2' => '11'
],[
'country_id' => 126,
'name' => 'Molėtai District Municipality',
'iso2' => '27'
],[
'country_id' => 126,
'name' => 'Kaišiadorys District Municipality',
'iso2' => '13'
],[
'country_id' => 126,
'name' => 'Kėdainiai District Municipality',
'iso2' => '18'
],[
'country_id' => 126,
'name' => 'Kupiškis District Municipality',
'iso2' => '23'
],[
'country_id' => 126,
'name' => 'Šiauliai County',
'iso2' => 'SA'
],[
'country_id' => 126,
'name' => 'Raseiniai District Municipality',
'iso2' => '38'
],[
'country_id' => 126,
'name' => 'Palanga City Municipality',
'iso2' => '31'
],[
'country_id' => 126,
'name' => 'Panevėžys City Municipality',
'iso2' => '32'
],[
'country_id' => 126,
'name' => 'Rietavas municipality',
'iso2' => '39'
],[
'country_id' => 126,
'name' => 'Kalvarija municipality',
'iso2' => '14'
],[
'country_id' => 126,
'name' => 'Vilnius District Municipality',
'iso2' => '58'
],[
'country_id' => 126,
'name' => 'Trakai District Municipality',
'iso2' => '52'
],[
'country_id' => 126,
'name' => 'Širvintos District Municipality',
'iso2' => '47'
],[
'country_id' => 126,
'name' => 'Pakruojis District Municipality',
'iso2' => '30'
],[
'country_id' => 126,
'name' => 'Ukmergė District Municipality',
'iso2' => '53'
],[
'country_id' => 126,
'name' => 'Klaipeda City Municipality',
'iso2' => '20'
],[
'country_id' => 126,
'name' => 'Utena District Municipality',
'iso2' => '54'
],[
'country_id' => 126,
'name' => 'Alytus District Municipality',
'iso2' => '03'
],[
'country_id' => 126,
'name' => 'Klaipėda County',
'iso2' => 'KL'
],[
'country_id' => 126,
'name' => 'Vilnius County',
'iso2' => 'VL'
],[
'country_id' => 126,
'name' => 'Varėna District Municipality',
'iso2' => '55'
],[
'country_id' => 126,
'name' => 'Birštonas Municipality',
'iso2' => '05'
],[
'country_id' => 126,
'name' => 'Klaipėda District Municipality',
'iso2' => '21'
],[
'country_id' => 126,
'name' => 'Alytus City Municipality',
'iso2' => '02'
],[
'country_id' => 126,
'name' => 'Vilnius City Municipality',
'iso2' => '57'
],[
'country_id' => 126,
'name' => 'Šilutė District Municipality',
'iso2' => '46'
],[
'country_id' => 126,
'name' => 'Telšiai District Municipality',
'iso2' => '51'
],[
'country_id' => 126,
'name' => 'Šiauliai City Municipality',
'iso2' => '43'
],[
'country_id' => 126,
'name' => 'Marijampolė Municipality',
'iso2' => '25'
],[
'country_id' => 126,
'name' => 'Lazdijai District Municipality',
'iso2' => '24'
],[
'country_id' => 126,
'name' => 'Pagėgiai municipality',
'iso2' => '29'
],[
'country_id' => 126,
'name' => 'Šilalė District Municipality',
'iso2' => '45'
],[
'country_id' => 126,
'name' => 'Panevėžys District Municipality',
'iso2' => '33'
],[
'country_id' => 126,
'name' => 'Rokiškis District Municipality',
'iso2' => '40'
],[
'country_id' => 126,
'name' => 'Pasvalys District Municipality',
'iso2' => '34'
],[
'country_id' => 126,
'name' => 'Skuodas District Municipality',
'iso2' => '48'
],[
'country_id' => 126,
'name' => 'Kelmė District Municipality',
'iso2' => '19'
],[
'country_id' => 126,
'name' => 'Zarasai District Municipality',
'iso2' => '60'
],[
'country_id' => 126,
'name' => 'Vilkaviškis District Municipality',
'iso2' => '56'
],[
'country_id' => 126,
'name' => 'Utena County',
'iso2' => 'UT'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
