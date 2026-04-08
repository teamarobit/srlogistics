<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class DZStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 4,
'name' => 'Djelfa',
'iso2' => '17'
],[
'country_id' => 4,
'name' => 'El Oued',
'iso2' => '39'
],[
'country_id' => 4,
'name' => 'El Tarf',
'iso2' => '36'
],[
'country_id' => 4,
'name' => 'Oran',
'iso2' => '31'
],[
'country_id' => 4,
'name' => 'Naama',
'iso2' => '45'
],[
'country_id' => 4,
'name' => 'Annaba',
'iso2' => '23'
],[
'country_id' => 4,
'name' => 'Bouïra',
'iso2' => '10'
],[
'country_id' => 4,
'name' => 'Chlef',
'iso2' => '02'
],[
'country_id' => 4,
'name' => 'Tiaret',
'iso2' => '14'
],[
'country_id' => 4,
'name' => 'Tlemcen',
'iso2' => '13'
],[
'country_id' => 4,
'name' => 'Béchar',
'iso2' => '08'
],[
'country_id' => 4,
'name' => 'Médéa',
'iso2' => '26'
],[
'country_id' => 4,
'name' => 'Skikda',
'iso2' => '21'
],[
'country_id' => 4,
'name' => 'Blida',
'iso2' => '09'
],[
'country_id' => 4,
'name' => 'Illizi',
'iso2' => '33'
],[
'country_id' => 4,
'name' => 'Jijel',
'iso2' => '18'
],[
'country_id' => 4,
'name' => 'Biskra',
'iso2' => '07'
],[
'country_id' => 4,
'name' => 'Tipasa',
'iso2' => '42'
],[
'country_id' => 4,
'name' => 'Bordj Bou Arréridj',
'iso2' => '34'
],[
'country_id' => 4,
'name' => 'Tébessa',
'iso2' => '12'
],[
'country_id' => 4,
'name' => 'Adrar',
'iso2' => '01'
],[
'country_id' => 4,
'name' => 'Aïn Defla',
'iso2' => '44'
],[
'country_id' => 4,
'name' => 'Tindouf',
'iso2' => '37'
],[
'country_id' => 4,
'name' => 'Constantine',
'iso2' => '25'
],[
'country_id' => 4,
'name' => 'Aïn Témouchent',
'iso2' => '46'
],[
'country_id' => 4,
'name' => 'Saïda',
'iso2' => '20'
],[
'country_id' => 4,
'name' => 'Mascara',
'iso2' => '29'
],[
'country_id' => 4,
'name' => 'Boumerdès',
'iso2' => '35'
],[
'country_id' => 4,
'name' => 'Khenchela',
'iso2' => '40'
],[
'country_id' => 4,
'name' => 'Ghardaïa',
'iso2' => '47'
],[
'country_id' => 4,
'name' => 'Béjaïa',
'iso2' => '06'
],[
'country_id' => 4,
'name' => 'El Bayadh',
'iso2' => '32'
],[
'country_id' => 4,
'name' => 'Relizane',
'iso2' => '48'
],[
'country_id' => 4,
'name' => 'Tizi Ouzou',
'iso2' => '15'
],[
'country_id' => 4,
'name' => 'Mila',
'iso2' => '43'
],[
'country_id' => 4,
'name' => 'Tissemsilt',
'iso2' => '38'
],[
'country_id' => 4,
'name' => 'MSila',
'iso2' => '28'
],[
'country_id' => 4,
'name' => 'Tamanghasset',
'iso2' => '11'
],[
'country_id' => 4,
'name' => 'Oum El Bouaghi',
'iso2' => '04'
],[
'country_id' => 4,
'name' => 'Guelma',
'iso2' => '24'
],[
'country_id' => 4,
'name' => 'Laghouat',
'iso2' => '03'
],[
'country_id' => 4,
'name' => 'Ouargla',
'iso2' => '30'
],[
'country_id' => 4,
'name' => 'Mostaganem',
'iso2' => '27'
],[
'country_id' => 4,
'name' => 'Sétif',
'iso2' => '19'
],[
'country_id' => 4,
'name' => 'Batna',
'iso2' => '05'
],[
'country_id' => 4,
'name' => 'Souk Ahras',
'iso2' => '41'
],[
'country_id' => 4,
'name' => 'Algiers',
'iso2' => '16'
],[
'country_id' => 4,
'name' => 'Sidi Bel Abbès',
'iso2' => '22'
],[
'country_id' => 4,
'name' => 'El Mghair',
'iso2' => '49'
],[
'country_id' => 4,
'name' => 'El Menia',
'iso2' => '50'
],[
'country_id' => 4,
'name' => 'Ouled Djellal',
'iso2' => '51'
],[
'country_id' => 4,
'name' => 'Bordj Baji Mokhtar',
'iso2' => '52'
],[
'country_id' => 4,
'name' => 'Béni Abbès',
'iso2' => '53'
],[
'country_id' => 4,
'name' => 'Timimoun',
'iso2' => '54'
],[
'country_id' => 4,
'name' => 'Touggourt',
'iso2' => '55'
],[
'country_id' => 4,
'name' => 'Djanet',
'iso2' => '56'
],[
'country_id' => 4,
'name' => 'In Salah',
'iso2' => '57'
],[
'country_id' => 4,
'name' => 'In Guezzam',
'iso2' => '58'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
