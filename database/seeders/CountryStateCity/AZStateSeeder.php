<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class AZStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 16,
'name' => 'Shaki',
'iso2' => 'SA'
],[
'country_id' => 16,
'name' => 'Tartar District',
'iso2' => 'TAR'
],[
'country_id' => 16,
'name' => 'Shirvan',
'iso2' => 'SR'
],[
'country_id' => 16,
'name' => 'Qazakh District',
'iso2' => 'QAZ'
],[
'country_id' => 16,
'name' => 'Sadarak District',
'iso2' => 'SAD'
],[
'country_id' => 16,
'name' => 'Yevlakh District',
'iso2' => 'YEV'
],[
'country_id' => 16,
'name' => 'Khojali District',
'iso2' => 'XCI'
],[
'country_id' => 16,
'name' => 'Kalbajar District',
'iso2' => 'KAL'
],[
'country_id' => 16,
'name' => 'Qakh District',
'iso2' => 'QAX'
],[
'country_id' => 16,
'name' => 'Fizuli District',
'iso2' => 'FUZ'
],[
'country_id' => 16,
'name' => 'Astara District',
'iso2' => 'AST'
],[
'country_id' => 16,
'name' => 'Shamakhi District',
'iso2' => 'SMI'
],[
'country_id' => 16,
'name' => 'Neftchala District',
'iso2' => 'NEF'
],[
'country_id' => 16,
'name' => 'Goychay',
'iso2' => 'GOY'
],[
'country_id' => 16,
'name' => 'Bilasuvar District',
'iso2' => 'BIL'
],[
'country_id' => 16,
'name' => 'Tovuz District',
'iso2' => 'TOV'
],[
'country_id' => 16,
'name' => 'Ordubad District',
'iso2' => 'ORD'
],[
'country_id' => 16,
'name' => 'Sharur District',
'iso2' => 'SAR'
],[
'country_id' => 16,
'name' => 'Samukh District',
'iso2' => 'SMX'
],[
'country_id' => 16,
'name' => 'Khizi District',
'iso2' => 'XIZ'
],[
'country_id' => 16,
'name' => 'Yevlakh',
'iso2' => 'YE'
],[
'country_id' => 16,
'name' => 'Ujar District',
'iso2' => 'UCA'
],[
'country_id' => 16,
'name' => 'Absheron District',
'iso2' => 'ABS'
],[
'country_id' => 16,
'name' => 'Lachin District',
'iso2' => 'LAC'
],[
'country_id' => 16,
'name' => 'Qabala District',
'iso2' => 'QAB'
],[
'country_id' => 16,
'name' => 'Agstafa District',
'iso2' => 'AGA'
],[
'country_id' => 16,
'name' => 'Imishli District',
'iso2' => 'IMI'
],[
'country_id' => 16,
'name' => 'Salyan District',
'iso2' => 'SAL'
],[
'country_id' => 16,
'name' => 'Lerik District',
'iso2' => 'LER'
],[
'country_id' => 16,
'name' => 'Agsu District',
'iso2' => 'AGU'
],[
'country_id' => 16,
'name' => 'Qubadli District',
'iso2' => 'QBI'
],[
'country_id' => 16,
'name' => 'Kurdamir District',
'iso2' => 'KUR'
],[
'country_id' => 16,
'name' => 'Yardymli District',
'iso2' => 'YAR'
],[
'country_id' => 16,
'name' => 'Goranboy District',
'iso2' => 'GOR'
],[
'country_id' => 16,
'name' => 'Baku',
'iso2' => 'BA'
],[
'country_id' => 16,
'name' => 'Agdash District',
'iso2' => 'AGS'
],[
'country_id' => 16,
'name' => 'Beylagan District',
'iso2' => 'BEY'
],[
'country_id' => 16,
'name' => 'Masally District',
'iso2' => 'MAS'
],[
'country_id' => 16,
'name' => 'Oghuz District',
'iso2' => 'OGU'
],[
'country_id' => 16,
'name' => 'Saatly District',
'iso2' => 'SAT'
],[
'country_id' => 16,
'name' => 'Lankaran District',
'iso2' => 'LA'
],[
'country_id' => 16,
'name' => 'Agdam District',
'iso2' => 'AGM'
],[
'country_id' => 16,
'name' => 'Balakan District',
'iso2' => 'BAL'
],[
'country_id' => 16,
'name' => 'Dashkasan District',
'iso2' => 'DAS'
],[
'country_id' => 16,
'name' => 'Nakhchivan Autonomous Republic',
'iso2' => 'NX'
],[
'country_id' => 16,
'name' => 'Quba District',
'iso2' => 'QBA'
],[
'country_id' => 16,
'name' => 'Ismailli District',
'iso2' => 'ISM'
],[
'country_id' => 16,
'name' => 'Sabirabad District',
'iso2' => 'SAB'
],[
'country_id' => 16,
'name' => 'Zaqatala District',
'iso2' => 'ZAQ'
],[
'country_id' => 16,
'name' => 'Kangarli District',
'iso2' => 'KAN'
],[
'country_id' => 16,
'name' => 'Martuni',
'iso2' => 'XVD'
],[
'country_id' => 16,
'name' => 'Barda District',
'iso2' => 'BAR'
],[
'country_id' => 16,
'name' => 'Jabrayil District',
'iso2' => 'CAB'
],[
'country_id' => 16,
'name' => 'Hajigabul District',
'iso2' => 'HAC'
],[
'country_id' => 16,
'name' => 'Julfa District',
'iso2' => 'CUL'
],[
'country_id' => 16,
'name' => 'Gobustan District',
'iso2' => 'QOB'
],[
'country_id' => 16,
'name' => 'Goygol District',
'iso2' => 'GYG'
],[
'country_id' => 16,
'name' => 'Babek District',
'iso2' => 'BAB'
],[
'country_id' => 16,
'name' => 'Zardab District',
'iso2' => 'ZAR'
],[
'country_id' => 16,
'name' => 'Aghjabadi District',
'iso2' => 'AGC'
],[
'country_id' => 16,
'name' => 'Jalilabad District',
'iso2' => 'CAL'
],[
'country_id' => 16,
'name' => 'Shahbuz District',
'iso2' => 'SAH'
],[
'country_id' => 16,
'name' => 'Mingachevir',
'iso2' => 'MI'
],[
'country_id' => 16,
'name' => 'Zangilan District',
'iso2' => 'ZAN'
],[
'country_id' => 16,
'name' => 'Sumqayit',
'iso2' => 'SM'
],[
'country_id' => 16,
'name' => 'Shamkir District',
'iso2' => 'SKR'
],[
'country_id' => 16,
'name' => 'Siazan District',
'iso2' => 'SIY'
],[
'country_id' => 16,
'name' => 'Ganja',
'iso2' => 'GA'
],[
'country_id' => 16,
'name' => 'Shaki District',
'iso2' => 'SAK'
],[
'country_id' => 16,
'name' => 'Lankaran',
'iso2' => 'LAN'
],[
'country_id' => 16,
'name' => 'Qusar District',
'iso2' => 'QUS'
],[
'country_id' => 16,
'name' => 'Gədəbəy',
'iso2' => 'GAD'
],[
'country_id' => 16,
'name' => 'Khachmaz District',
'iso2' => 'XAC'
],[
'country_id' => 16,
'name' => 'Shabran District',
'iso2' => 'SBN'
],[
'country_id' => 16,
'name' => 'Shusha District',
'iso2' => 'SUS'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
