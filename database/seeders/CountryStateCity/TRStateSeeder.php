<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class TRStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 225,
'name' => 'Bartın',
'iso2' => '74'
],[
'country_id' => 225,
'name' => 'Kütahya',
'iso2' => '43'
],[
'country_id' => 225,
'name' => 'Sakarya',
'iso2' => '54'
],[
'country_id' => 225,
'name' => 'Edirne',
'iso2' => '22'
],[
'country_id' => 225,
'name' => 'Van',
'iso2' => '65'
],[
'country_id' => 225,
'name' => 'Bingöl',
'iso2' => '12'
],[
'country_id' => 225,
'name' => 'Kilis',
'iso2' => '79'
],[
'country_id' => 225,
'name' => 'Adıyaman',
'iso2' => '02'
],[
'country_id' => 225,
'name' => 'Mersin',
'iso2' => '33'
],[
'country_id' => 225,
'name' => 'Denizli',
'iso2' => '20'
],[
'country_id' => 225,
'name' => 'Malatya',
'iso2' => '44'
],[
'country_id' => 225,
'name' => 'Elazığ',
'iso2' => '23'
],[
'country_id' => 225,
'name' => 'Erzincan',
'iso2' => '24'
],[
'country_id' => 225,
'name' => 'Amasya',
'iso2' => '05'
],[
'country_id' => 225,
'name' => 'Muş',
'iso2' => '49'
],[
'country_id' => 225,
'name' => 'Bursa',
'iso2' => '16'
],[
'country_id' => 225,
'name' => 'Eskişehir',
'iso2' => '26'
],[
'country_id' => 225,
'name' => 'Erzurum',
'iso2' => '25'
],[
'country_id' => 225,
'name' => 'Iğdır',
'iso2' => '76'
],[
'country_id' => 225,
'name' => 'Tekirdağ',
'iso2' => '59'
],[
'country_id' => 225,
'name' => 'Çankırı',
'iso2' => '18'
],[
'country_id' => 225,
'name' => 'Antalya',
'iso2' => '07'
],[
'country_id' => 225,
'name' => 'İstanbul',
'iso2' => '34'
],[
'country_id' => 225,
'name' => 'Konya',
'iso2' => '42'
],[
'country_id' => 225,
'name' => 'Bolu',
'iso2' => '14'
],[
'country_id' => 225,
'name' => 'Çorum',
'iso2' => '19'
],[
'country_id' => 225,
'name' => 'Ordu',
'iso2' => '52'
],[
'country_id' => 225,
'name' => 'Balıkesir',
'iso2' => '10'
],[
'country_id' => 225,
'name' => 'Kırklareli',
'iso2' => '39'
],[
'country_id' => 225,
'name' => 'Bayburt',
'iso2' => '69'
],[
'country_id' => 225,
'name' => 'Kırıkkale',
'iso2' => '71'
],[
'country_id' => 225,
'name' => 'Afyonkarahisar',
'iso2' => '03'
],[
'country_id' => 225,
'name' => 'Kırşehir',
'iso2' => '40'
],[
'country_id' => 225,
'name' => 'Sivas',
'iso2' => '58'
],[
'country_id' => 225,
'name' => 'Muğla',
'iso2' => '48'
],[
'country_id' => 225,
'name' => 'Şanlıurfa',
'iso2' => '63'
],[
'country_id' => 225,
'name' => 'Karaman',
'iso2' => '70'
],[
'country_id' => 225,
'name' => 'Ardahan',
'iso2' => '75'
],[
'country_id' => 225,
'name' => 'Giresun',
'iso2' => '28'
],[
'country_id' => 225,
'name' => 'Aydın',
'iso2' => '09'
],[
'country_id' => 225,
'name' => 'Yozgat',
'iso2' => '66'
],[
'country_id' => 225,
'name' => 'Niğde',
'iso2' => '51'
],[
'country_id' => 225,
'name' => 'Hakkâri',
'iso2' => '30'
],[
'country_id' => 225,
'name' => 'Artvin',
'iso2' => '08'
],[
'country_id' => 225,
'name' => 'Tunceli',
'iso2' => '62'
],[
'country_id' => 225,
'name' => 'Ağrı',
'iso2' => '04'
],[
'country_id' => 225,
'name' => 'Batman',
'iso2' => '72'
],[
'country_id' => 225,
'name' => 'Kocaeli',
'iso2' => '41'
],[
'country_id' => 225,
'name' => 'Nevşehir',
'iso2' => '50'
],[
'country_id' => 225,
'name' => 'Kastamonu',
'iso2' => '37'
],[
'country_id' => 225,
'name' => 'Manisa',
'iso2' => '45'
],[
'country_id' => 225,
'name' => 'Tokat',
'iso2' => '60'
],[
'country_id' => 225,
'name' => 'Kayseri',
'iso2' => '38'
],[
'country_id' => 225,
'name' => 'Uşak',
'iso2' => '64'
],[
'country_id' => 225,
'name' => 'Düzce',
'iso2' => '81'
],[
'country_id' => 225,
'name' => 'Gaziantep',
'iso2' => '27'
],[
'country_id' => 225,
'name' => 'Gümüşhane',
'iso2' => '29'
],[
'country_id' => 225,
'name' => 'İzmir',
'iso2' => '35'
],[
'country_id' => 225,
'name' => 'Trabzon',
'iso2' => '61'
],[
'country_id' => 225,
'name' => 'Siirt',
'iso2' => '56'
],[
'country_id' => 225,
'name' => 'Kars',
'iso2' => '36'
],[
'country_id' => 225,
'name' => 'Burdur',
'iso2' => '15'
],[
'country_id' => 225,
'name' => 'Aksaray',
'iso2' => '68'
],[
'country_id' => 225,
'name' => 'Hatay',
'iso2' => '31'
],[
'country_id' => 225,
'name' => 'Adana',
'iso2' => '01'
],[
'country_id' => 225,
'name' => 'Zonguldak',
'iso2' => '67'
],[
'country_id' => 225,
'name' => 'Osmaniye',
'iso2' => '80'
],[
'country_id' => 225,
'name' => 'Bitlis',
'iso2' => '13'
],[
'country_id' => 225,
'name' => 'Çanakkale',
'iso2' => '17'
],[
'country_id' => 225,
'name' => 'Ankara',
'iso2' => '06'
],[
'country_id' => 225,
'name' => 'Yalova',
'iso2' => '77'
],[
'country_id' => 225,
'name' => 'Rize',
'iso2' => '53'
],[
'country_id' => 225,
'name' => 'Samsun',
'iso2' => '55'
],[
'country_id' => 225,
'name' => 'Bilecik',
'iso2' => '11'
],[
'country_id' => 225,
'name' => 'Isparta',
'iso2' => '32'
],[
'country_id' => 225,
'name' => 'Karabük',
'iso2' => '78'
],[
'country_id' => 225,
'name' => 'Mardin',
'iso2' => '47'
],[
'country_id' => 225,
'name' => 'Şırnak',
'iso2' => '73'
],[
'country_id' => 225,
'name' => 'Diyarbakır',
'iso2' => '21'
],[
'country_id' => 225,
'name' => 'Kahramanmaraş',
'iso2' => '46'
],[
'country_id' => 225,
'name' => 'Sinop',
'iso2' => '57'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
