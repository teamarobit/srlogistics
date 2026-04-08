<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class MAStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 149,
'name' => 'Guelmim',
'iso2' => 'GUE'
],[
'country_id' => 149,
'name' => 'Aousserd (EH)',
'iso2' => 'AOU'
],[
'country_id' => 149,
'name' => 'Al Hoceïma',
'iso2' => 'HOC'
],[
'country_id' => 149,
'name' => 'Larache',
'iso2' => 'LAR'
],[
'country_id' => 149,
'name' => 'Ouarzazate',
'iso2' => 'OUA'
],[
'country_id' => 149,
'name' => 'Boulemane',
'iso2' => 'BOM'
],[
'country_id' => 149,
'name' => 'L\'Oriental',
'iso2' => '02'
],[
'country_id' => 149,
'name' => 'Béni Mellal',
'iso2' => 'BEM'
],[
'country_id' => 149,
'name' => 'Chichaoua',
'iso2' => 'CHI'
],[
'country_id' => 149,
'name' => 'Boujdour (EH)',
'iso2' => 'BOD'
],[
'country_id' => 149,
'name' => 'Khémisset',
'iso2' => 'KHE'
],[
'country_id' => 149,
'name' => 'Tiznit',
'iso2' => 'TIZ'
],[
'country_id' => 149,
'name' => 'Béni Mellal-Khénifra',
'iso2' => '05'
],[
'country_id' => 149,
'name' => 'Sidi Kacem',
'iso2' => 'SIK'
],[
'country_id' => 149,
'name' => 'El Jadida',
'iso2' => 'JDI'
],[
'country_id' => 149,
'name' => 'Nador',
'iso2' => 'NAD'
],[
'country_id' => 149,
'name' => 'Settat',
'iso2' => 'SET'
],[
'country_id' => 149,
'name' => 'Zagora',
'iso2' => 'ZAG'
],[
'country_id' => 149,
'name' => 'Médiouna',
'iso2' => 'MED'
],[
'country_id' => 149,
'name' => 'Berkane',
'iso2' => 'BER'
],[
'country_id' => 149,
'name' => 'Tan-Tan (EH-partial)',
'iso2' => 'TNT'
],[
'country_id' => 149,
'name' => 'Nouaceur',
'iso2' => 'NOU'
],[
'country_id' => 149,
'name' => 'Marrakesh-Safi',
'iso2' => '07'
],[
'country_id' => 149,
'name' => 'Sefrou',
'iso2' => 'SEF'
],[
'country_id' => 149,
'name' => 'Drâa-Tafilalet',
'iso2' => '08'
],[
'country_id' => 149,
'name' => 'El Hajeb',
'iso2' => 'HAJ'
],[
'country_id' => 149,
'name' => 'Es-Semara (EH-partial)',
'iso2' => 'ESM'
],[
'country_id' => 149,
'name' => 'Laâyoune (EH)',
'iso2' => 'LAA'
],[
'country_id' => 149,
'name' => 'Inezgane-Ait Melloul',
'iso2' => 'INE'
],[
'country_id' => 149,
'name' => 'Souss-Massa',
'iso2' => '09'
],[
'country_id' => 149,
'name' => 'Taza',
'iso2' => 'TAZ'
],[
'country_id' => 149,
'name' => 'Assa-Zag (EH-partial)',
'iso2' => 'ASZ'
],[
'country_id' => 149,
'name' => 'Laâyoune-Sakia El Hamra (EH-partial)',
'iso2' => '11'
],[
'country_id' => 149,
'name' => 'Errachidia',
'iso2' => 'ERR'
],[
'country_id' => 149,
'name' => 'Fahs-Anjra',
'iso2' => 'FAH'
],[
'country_id' => 149,
'name' => 'Figuig',
'iso2' => 'FIG'
],[
'country_id' => 149,
'name' => 'Chtouka-Ait Baha',
'iso2' => 'CHT'
],[
'country_id' => 149,
'name' => 'Casablanca-Settat',
'iso2' => '06'
],[
'country_id' => 149,
'name' => 'Benslimane',
'iso2' => 'BES'
],[
'country_id' => 149,
'name' => 'Guelmim-Oued Noun (EH-partial)',
'iso2' => '10'
],[
'country_id' => 149,
'name' => 'Dakhla-Oued Ed-Dahab (EH)',
'iso2' => '12'
],[
'country_id' => 149,
'name' => 'Jerada',
'iso2' => 'JRA'
],[
'country_id' => 149,
'name' => 'Kénitra',
'iso2' => 'KEN'
],[
'country_id' => 149,
'name' => 'El Kelâa des Sraghna',
'iso2' => 'KES'
],[
'country_id' => 149,
'name' => 'Chefchaouen',
'iso2' => 'CHE'
],[
'country_id' => 149,
'name' => 'Safi',
'iso2' => 'SAF'
],[
'country_id' => 149,
'name' => 'Tata',
'iso2' => 'TAT'
],[
'country_id' => 149,
'name' => 'Fès-Meknès',
'iso2' => '03'
],[
'country_id' => 149,
'name' => 'Taroudannt',
'iso2' => 'TAR'
],[
'country_id' => 149,
'name' => 'Moulay Yacoub',
'iso2' => 'MOU'
],[
'country_id' => 149,
'name' => 'Essaouira',
'iso2' => 'ESI'
],[
'country_id' => 149,
'name' => 'Khénifra',
'iso2' => 'KHN'
],[
'country_id' => 149,
'name' => 'Tétouan',
'iso2' => 'TET'
],[
'country_id' => 149,
'name' => 'Oued Ed-Dahab (EH)',
'iso2' => 'OUD'
],[
'country_id' => 149,
'name' => 'Al Haouz',
'iso2' => 'HAO'
],[
'country_id' => 149,
'name' => 'Azilal',
'iso2' => 'AZI'
],[
'country_id' => 149,
'name' => 'Taourirt',
'iso2' => 'TAI'
],[
'country_id' => 149,
'name' => 'Taounate',
'iso2' => 'TAO'
],[
'country_id' => 149,
'name' => 'Tanger-Tétouan-Al Hoceïma',
'iso2' => '01'
],[
'country_id' => 149,
'name' => 'Ifrane',
'iso2' => 'IFR'
],[
'country_id' => 149,
'name' => 'Khouribga',
'iso2' => 'KHO'
],[
'country_id' => 149,
'name' => 'Rabat-Salé-Kénitra',
'iso2' => '04'
],[
'country_id' => 149,
'name' => 'Agadir-Ida-Ou-Tanane',
'iso2' => 'AGD'
],[
'country_id' => 149,
'name' => 'Berrechid',
'iso2' => 'BRR'
],[
'country_id' => 149,
'name' => 'Casablanca',
'iso2' => 'CAS'
],[
'country_id' => 149,
'name' => 'Driouch',
'iso2' => 'DRI'
],[
'country_id' => 149,
'name' => 'Fès',
'iso2' => 'FES'
],[
'country_id' => 149,
'name' => 'Fquih Ben Salah',
'iso2' => 'FQH'
],[
'country_id' => 149,
'name' => 'Guercif',
'iso2' => 'GUF'
],[
'country_id' => 149,
'name' => 'Marrakech',
'iso2' => 'MAR'
],[
'country_id' => 149,
'name' => 'M’diq-Fnideq',
'iso2' => 'MDF'
],[
'country_id' => 149,
'name' => 'Meknès',
'iso2' => 'MEK'
],[
'country_id' => 149,
'name' => 'Midelt',
'iso2' => 'MID'
],[
'country_id' => 149,
'name' => 'Mohammadia',
'iso2' => 'MOH'
],[
'country_id' => 149,
'name' => 'Oujda-Angad',
'iso2' => 'OUJ'
],[
'country_id' => 149,
'name' => 'Ouezzane',
'iso2' => 'OUZ'
],[
'country_id' => 149,
'name' => 'Rabat',
'iso2' => 'RAB'
],[
'country_id' => 149,
'name' => 'Rehamna',
'iso2' => 'REH'
],[
'country_id' => 149,
'name' => 'Salé',
'iso2' => 'SAL'
],[
'country_id' => 149,
'name' => 'Sidi Bennour',
'iso2' => 'SIB'
],[
'country_id' => 149,
'name' => 'Sidi Ifni',
'iso2' => 'SIF'
],[
'country_id' => 149,
'name' => 'Skhirate-Témara',
'iso2' => 'SKH'
],[
'country_id' => 149,
'name' => 'Tarfaya (EH-partial)',
'iso2' => 'TAF'
],[
'country_id' => 149,
'name' => 'Tinghir',
'iso2' => 'TIN'
],[
'country_id' => 149,
'name' => 'Tanger-Assilah',
'iso2' => 'TNG'
],[
'country_id' => 149,
'name' => 'Youssoufia',
'iso2' => 'YUS'
],[
'country_id' => 149,
'name' => 'Sidi Slimane',
'iso2' => 'SIL'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
