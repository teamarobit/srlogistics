<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class THStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 219,
'name' => 'Krabi',
'iso2' => '81'
],[
'country_id' => 219,
'name' => 'Ranong',
'iso2' => '85'
],[
'country_id' => 219,
'name' => 'Nong Bua Lam Phu',
'iso2' => '39'
],[
'country_id' => 219,
'name' => 'Samut Prakan',
'iso2' => '11'
],[
'country_id' => 219,
'name' => 'Surat Thani',
'iso2' => '84'
],[
'country_id' => 219,
'name' => 'Lamphun',
'iso2' => '51'
],[
'country_id' => 219,
'name' => 'Nong Khai',
'iso2' => '43'
],[
'country_id' => 219,
'name' => 'Khon Kaen',
'iso2' => '40'
],[
'country_id' => 219,
'name' => 'Chanthaburi',
'iso2' => '22'
],[
'country_id' => 219,
'name' => 'Saraburi',
'iso2' => '19'
],[
'country_id' => 219,
'name' => 'Phatthalung',
'iso2' => '93'
],[
'country_id' => 219,
'name' => 'Uttaradit',
'iso2' => '53'
],[
'country_id' => 219,
'name' => 'Sing Buri',
'iso2' => '17'
],[
'country_id' => 219,
'name' => 'Chiang Mai',
'iso2' => '50'
],[
'country_id' => 219,
'name' => 'Nakhon Sawan',
'iso2' => '60'
],[
'country_id' => 219,
'name' => 'Yala',
'iso2' => '95'
],[
'country_id' => 219,
'name' => 'Phra Nakhon Si Ayutthaya',
'iso2' => '14'
],[
'country_id' => 219,
'name' => 'Nonthaburi',
'iso2' => '12'
],[
'country_id' => 219,
'name' => 'Trat',
'iso2' => '23'
],[
'country_id' => 219,
'name' => 'Nakhon Ratchasima',
'iso2' => '30'
],[
'country_id' => 219,
'name' => 'Chiang Rai',
'iso2' => '57'
],[
'country_id' => 219,
'name' => 'Ratchaburi',
'iso2' => '70'
],[
'country_id' => 219,
'name' => 'Pathum Thani',
'iso2' => '13'
],[
'country_id' => 219,
'name' => 'Sakon Nakhon',
'iso2' => '47'
],[
'country_id' => 219,
'name' => 'Samut Songkhram',
'iso2' => '75'
],[
'country_id' => 219,
'name' => 'Nakhon Pathom',
'iso2' => '73'
],[
'country_id' => 219,
'name' => 'Samut Sakhon',
'iso2' => '74'
],[
'country_id' => 219,
'name' => 'Mae Hong Son',
'iso2' => '58'
],[
'country_id' => 219,
'name' => 'Phitsanulok',
'iso2' => '65'
],[
'country_id' => 219,
'name' => 'Pattaya',
'iso2' => 'S'
],[
'country_id' => 219,
'name' => 'Prachuap Khiri Khan',
'iso2' => '77'
],[
'country_id' => 219,
'name' => 'Loei',
'iso2' => '42'
],[
'country_id' => 219,
'name' => 'Roi Et',
'iso2' => '45'
],[
'country_id' => 219,
'name' => 'Kanchanaburi',
'iso2' => '71'
],[
'country_id' => 219,
'name' => 'Ubon Ratchathani',
'iso2' => '34'
],[
'country_id' => 219,
'name' => 'Chon Buri',
'iso2' => '20'
],[
'country_id' => 219,
'name' => 'Phichit',
'iso2' => '66'
],[
'country_id' => 219,
'name' => 'Phetchabun',
'iso2' => '67'
],[
'country_id' => 219,
'name' => 'Kamphaeng Phet',
'iso2' => '62'
],[
'country_id' => 219,
'name' => 'Maha Sarakham',
'iso2' => '44'
],[
'country_id' => 219,
'name' => 'Rayong',
'iso2' => '21'
],[
'country_id' => 219,
'name' => 'Ang Thong',
'iso2' => '15'
],[
'country_id' => 219,
'name' => 'Nakhon Si Thammarat',
'iso2' => '80'
],[
'country_id' => 219,
'name' => 'Yasothon',
'iso2' => '35'
],[
'country_id' => 219,
'name' => 'Chai Nat',
'iso2' => '18'
],[
'country_id' => 219,
'name' => 'Amnat Charoen',
'iso2' => '37'
],[
'country_id' => 219,
'name' => 'Suphan Buri',
'iso2' => '72'
],[
'country_id' => 219,
'name' => 'Tak',
'iso2' => '63'
],[
'country_id' => 219,
'name' => 'Chumphon',
'iso2' => '86'
],[
'country_id' => 219,
'name' => 'Udon Thani',
'iso2' => '41'
],[
'country_id' => 219,
'name' => 'Phrae',
'iso2' => '54'
],[
'country_id' => 219,
'name' => 'Sa Kaeo',
'iso2' => '27'
],[
'country_id' => 219,
'name' => 'Nan',
'iso2' => '55'
],[
'country_id' => 219,
'name' => 'Surin',
'iso2' => '32'
],[
'country_id' => 219,
'name' => 'Phetchaburi',
'iso2' => '76'
],[
'country_id' => 219,
'name' => 'Bueng Kan',
'iso2' => '38'
],[
'country_id' => 219,
'name' => 'Buri Ram',
'iso2' => '31'
],[
'country_id' => 219,
'name' => 'Nakhon Nayok',
'iso2' => '26'
],[
'country_id' => 219,
'name' => 'Phuket',
'iso2' => '83'
],[
'country_id' => 219,
'name' => 'Satun',
'iso2' => '91'
],[
'country_id' => 219,
'name' => 'Phayao',
'iso2' => '56'
],[
'country_id' => 219,
'name' => 'Songkhla',
'iso2' => '90'
],[
'country_id' => 219,
'name' => 'Pattani',
'iso2' => '94'
],[
'country_id' => 219,
'name' => 'Trang',
'iso2' => '92'
],[
'country_id' => 219,
'name' => 'Prachin Buri',
'iso2' => '25'
],[
'country_id' => 219,
'name' => 'Lop Buri',
'iso2' => '16'
],[
'country_id' => 219,
'name' => 'Lampang',
'iso2' => '52'
],[
'country_id' => 219,
'name' => 'Sukhothai',
'iso2' => '64'
],[
'country_id' => 219,
'name' => 'Mukdahan',
'iso2' => '49'
],[
'country_id' => 219,
'name' => 'Si Sa Ket',
'iso2' => '33'
],[
'country_id' => 219,
'name' => 'Nakhon Phanom',
'iso2' => '48'
],[
'country_id' => 219,
'name' => 'Phangnga',
'iso2' => '82'
],[
'country_id' => 219,
'name' => 'Kalasin',
'iso2' => '46'
],[
'country_id' => 219,
'name' => 'Uthai Thani',
'iso2' => '61'
],[
'country_id' => 219,
'name' => 'Chachoengsao',
'iso2' => '24'
],[
'country_id' => 219,
'name' => 'Narathiwat',
'iso2' => '96'
],[
'country_id' => 219,
'name' => 'Bangkok',
'iso2' => '10'
],[
'country_id' => 219,
'name' => 'Chaiyaphum',
'iso2' => '36'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
