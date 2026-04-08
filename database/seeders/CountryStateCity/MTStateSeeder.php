<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class MTStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 135,
'name' => 'Mqabba',
'iso2' => '33'
],[
'country_id' => 135,
'name' => 'San Ġwann',
'iso2' => '49'
],[
'country_id' => 135,
'name' => 'Żurrieq',
'iso2' => '68'
],[
'country_id' => 135,
'name' => 'Luqa',
'iso2' => '25'
],[
'country_id' => 135,
'name' => 'Marsaxlokk',
'iso2' => '28'
],[
'country_id' => 135,
'name' => 'Qala',
'iso2' => '42'
],[
'country_id' => 135,
'name' => 'Żebbuġ Malta',
'iso2' => '66'
],[
'country_id' => 135,
'name' => 'Xgħajra',
'iso2' => '63'
],[
'country_id' => 135,
'name' => 'Kirkop',
'iso2' => '23'
],[
'country_id' => 135,
'name' => 'Rabat',
'iso2' => '46'
],[
'country_id' => 135,
'name' => 'Floriana',
'iso2' => '09'
],[
'country_id' => 135,
'name' => 'Żebbuġ Gozo',
'iso2' => '65'
],[
'country_id' => 135,
'name' => 'Swieqi',
'iso2' => '57'
],[
'country_id' => 135,
'name' => 'Saint Lawrence',
'iso2' => '50'
],[
'country_id' => 135,
'name' => 'Birżebbuġa',
'iso2' => '05'
],[
'country_id' => 135,
'name' => 'Mdina',
'iso2' => '29'
],[
'country_id' => 135,
'name' => 'Santa Venera',
'iso2' => '54'
],[
'country_id' => 135,
'name' => 'Kerċem',
'iso2' => '22'
],[
'country_id' => 135,
'name' => 'Għarb',
'iso2' => '14'
],[
'country_id' => 135,
'name' => 'Iklin',
'iso2' => '19'
],[
'country_id' => 135,
'name' => 'Santa Luċija',
'iso2' => '53'
],[
'country_id' => 135,
'name' => 'Valletta',
'iso2' => '60'
],[
'country_id' => 135,
'name' => 'Msida',
'iso2' => '34'
],[
'country_id' => 135,
'name' => 'Birkirkara',
'iso2' => '04'
],[
'country_id' => 135,
'name' => 'Siġġiewi',
'iso2' => '55'
],[
'country_id' => 135,
'name' => 'Kalkara',
'iso2' => '21'
],[
'country_id' => 135,
'name' => 'St. Julian\'s',
'iso2' => '48'
],[
'country_id' => 135,
'name' => 'Victoria',
'iso2' => '45'
],[
'country_id' => 135,
'name' => 'Mellieħa',
'iso2' => '30'
],[
'country_id' => 135,
'name' => 'Tarxien',
'iso2' => '59'
],[
'country_id' => 135,
'name' => 'Sliema',
'iso2' => '56'
],[
'country_id' => 135,
'name' => 'Ħamrun',
'iso2' => '18'
],[
'country_id' => 135,
'name' => 'Għasri',
'iso2' => '16'
],[
'country_id' => 135,
'name' => 'Birgu',
'iso2' => '03'
],[
'country_id' => 135,
'name' => 'Balzan',
'iso2' => '02'
],[
'country_id' => 135,
'name' => 'Mġarr',
'iso2' => '31'
],[
'country_id' => 135,
'name' => 'Attard',
'iso2' => '01'
],[
'country_id' => 135,
'name' => 'Qrendi',
'iso2' => '44'
],[
'country_id' => 135,
'name' => 'Naxxar',
'iso2' => '38'
],[
'country_id' => 135,
'name' => 'Gżira',
'iso2' => '12'
],[
'country_id' => 135,
'name' => 'Xagħra',
'iso2' => '61'
],[
'country_id' => 135,
'name' => 'Paola',
'iso2' => '39'
],[
'country_id' => 135,
'name' => 'Sannat',
'iso2' => '52'
],[
'country_id' => 135,
'name' => 'Dingli',
'iso2' => '07'
],[
'country_id' => 135,
'name' => 'Gudja',
'iso2' => '11'
],[
'country_id' => 135,
'name' => 'Qormi',
'iso2' => '43'
],[
'country_id' => 135,
'name' => 'Għargħur',
'iso2' => '15'
],[
'country_id' => 135,
'name' => 'Xewkija',
'iso2' => '62'
],[
'country_id' => 135,
'name' => 'Ta\' Xbiex',
'iso2' => '58'
],[
'country_id' => 135,
'name' => 'Żabbar',
'iso2' => '64'
],[
'country_id' => 135,
'name' => 'Għaxaq',
'iso2' => '17'
],[
'country_id' => 135,
'name' => 'Pembroke',
'iso2' => '40'
],[
'country_id' => 135,
'name' => 'Lija',
'iso2' => '24'
],[
'country_id' => 135,
'name' => 'Pietà',
'iso2' => '41'
],[
'country_id' => 135,
'name' => 'Marsa',
'iso2' => '26'
],[
'country_id' => 135,
'name' => 'Fgura',
'iso2' => '08'
],[
'country_id' => 135,
'name' => 'Għajnsielem',
'iso2' => '13'
],[
'country_id' => 135,
'name' => 'Mtarfa',
'iso2' => '35'
],[
'country_id' => 135,
'name' => 'Munxar',
'iso2' => '36'
],[
'country_id' => 135,
'name' => 'Nadur',
'iso2' => '37'
],[
'country_id' => 135,
'name' => 'Fontana',
'iso2' => '10'
],[
'country_id' => 135,
'name' => 'Żejtun',
'iso2' => '67'
],[
'country_id' => 135,
'name' => 'Senglea',
'iso2' => '20'
],[
'country_id' => 135,
'name' => 'Marsaskala',
'iso2' => '27'
],[
'country_id' => 135,
'name' => 'Cospicua',
'iso2' => '06'
],[
'country_id' => 135,
'name' => 'St. Paul\'s Bay',
'iso2' => '51'
],[
'country_id' => 135,
'name' => 'Mosta',
'iso2' => '32'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
