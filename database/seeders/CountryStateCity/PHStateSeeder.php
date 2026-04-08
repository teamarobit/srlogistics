<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class PHStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 174,
'name' => 'Romblon',
'iso2' => 'ROM'
],[
'country_id' => 174,
'name' => 'Bukidnon',
'iso2' => 'BUK'
],[
'country_id' => 174,
'name' => 'Rizal',
'iso2' => 'RIZ'
],[
'country_id' => 174,
'name' => 'Bohol',
'iso2' => 'BOH'
],[
'country_id' => 174,
'name' => 'Quirino',
'iso2' => 'QUI'
],[
'country_id' => 174,
'name' => 'Biliran',
'iso2' => 'BIL'
],[
'country_id' => 174,
'name' => 'Quezon',
'iso2' => 'QUE'
],[
'country_id' => 174,
'name' => 'Siquijor',
'iso2' => 'SIG'
],[
'country_id' => 174,
'name' => 'Sarangani',
'iso2' => 'SAR'
],[
'country_id' => 174,
'name' => 'Bulacan',
'iso2' => 'BUL'
],[
'country_id' => 174,
'name' => 'Cagayan',
'iso2' => 'CAG'
],[
'country_id' => 174,
'name' => 'South Cotabato',
'iso2' => 'SCO'
],[
'country_id' => 174,
'name' => 'Sorsogon',
'iso2' => 'SOR'
],[
'country_id' => 174,
'name' => 'Sultan Kudarat',
'iso2' => 'SUK'
],[
'country_id' => 174,
'name' => 'Camarines Norte',
'iso2' => 'CAN'
],[
'country_id' => 174,
'name' => 'Southern Leyte',
'iso2' => 'SLE'
],[
'country_id' => 174,
'name' => 'Camiguin',
'iso2' => 'CAM'
],[
'country_id' => 174,
'name' => 'Surigao del Norte',
'iso2' => 'SUN'
],[
'country_id' => 174,
'name' => 'Camarines Sur',
'iso2' => 'CAS'
],[
'country_id' => 174,
'name' => 'Sulu',
'iso2' => 'SLU'
],[
'country_id' => 174,
'name' => 'Davao Oriental',
'iso2' => 'DAO'
],[
'country_id' => 174,
'name' => 'Eastern Samar',
'iso2' => 'EAS'
],[
'country_id' => 174,
'name' => 'Dinagat Islands',
'iso2' => 'DIN'
],[
'country_id' => 174,
'name' => 'Capiz',
'iso2' => 'CAP'
],[
'country_id' => 174,
'name' => 'Tawi-Tawi',
'iso2' => 'TAW'
],[
'country_id' => 174,
'name' => 'Calabarzon',
'iso2' => '40'
],[
'country_id' => 174,
'name' => 'Tarlac',
'iso2' => 'TAR'
],[
'country_id' => 174,
'name' => 'Surigao del Sur',
'iso2' => 'SUR'
],[
'country_id' => 174,
'name' => 'Zambales',
'iso2' => 'ZMB'
],[
'country_id' => 174,
'name' => 'Ilocos Norte',
'iso2' => 'ILN'
],[
'country_id' => 174,
'name' => 'Mimaropa',
'iso2' => '41'
],[
'country_id' => 174,
'name' => 'Ifugao',
'iso2' => 'IFU'
],[
'country_id' => 174,
'name' => 'Catanduanes',
'iso2' => 'CAT'
],[
'country_id' => 174,
'name' => 'Zamboanga del Norte',
'iso2' => 'ZAN'
],[
'country_id' => 174,
'name' => 'Guimaras',
'iso2' => 'GUI'
],[
'country_id' => 174,
'name' => 'Bicol',
'iso2' => '05'
],[
'country_id' => 174,
'name' => 'Western Visayas',
'iso2' => '06'
],[
'country_id' => 174,
'name' => 'Cebu',
'iso2' => 'CEB'
],[
'country_id' => 174,
'name' => 'Cavite',
'iso2' => 'CAV'
],[
'country_id' => 174,
'name' => 'Central Visayas',
'iso2' => '07'
],[
'country_id' => 174,
'name' => 'Davao Occidental',
'iso2' => 'DVO'
],[
'country_id' => 174,
'name' => 'Soccsksargen',
'iso2' => '12'
],[
'country_id' => 174,
'name' => 'Compostela Valley',
'iso2' => 'COM'
],[
'country_id' => 174,
'name' => 'Kalinga',
'iso2' => 'KAL'
],[
'country_id' => 174,
'name' => 'Isabela',
'iso2' => 'ISA'
],[
'country_id' => 174,
'name' => 'Caraga',
'iso2' => '13'
],[
'country_id' => 174,
'name' => 'Iloilo',
'iso2' => 'ILI'
],[
'country_id' => 174,
'name' => 'Autonomous Region in Muslim Mindanao',
'iso2' => '14'
],[
'country_id' => 174,
'name' => 'La Union',
'iso2' => 'LUN'
],[
'country_id' => 174,
'name' => 'Davao del Sur',
'iso2' => 'DAS'
],[
'country_id' => 174,
'name' => 'Davao del Norte',
'iso2' => 'DAV'
],[
'country_id' => 174,
'name' => 'Cotabato',
'iso2' => 'NCO'
],[
'country_id' => 174,
'name' => 'Ilocos Sur',
'iso2' => 'ILS'
],[
'country_id' => 174,
'name' => 'Eastern Visayas',
'iso2' => '08'
],[
'country_id' => 174,
'name' => 'Agusan del Norte',
'iso2' => 'AGN'
],[
'country_id' => 174,
'name' => 'Abra',
'iso2' => 'ABR'
],[
'country_id' => 174,
'name' => 'Zamboanga Peninsula',
'iso2' => '09'
],[
'country_id' => 174,
'name' => 'Agusan del Sur',
'iso2' => 'AGS'
],[
'country_id' => 174,
'name' => 'Lanao del Norte',
'iso2' => 'LAN'
],[
'country_id' => 174,
'name' => 'Laguna',
'iso2' => 'LAG'
],[
'country_id' => 174,
'name' => 'Marinduque',
'iso2' => 'MAD'
],[
'country_id' => 174,
'name' => 'Maguindanao',
'iso2' => 'MAG'
],[
'country_id' => 174,
'name' => 'Aklan',
'iso2' => 'AKL'
],[
'country_id' => 174,
'name' => 'Leyte',
'iso2' => 'LEY'
],[
'country_id' => 174,
'name' => 'Lanao del Sur',
'iso2' => 'LAS'
],[
'country_id' => 174,
'name' => 'Apayao',
'iso2' => 'APA'
],[
'country_id' => 174,
'name' => 'Cordillera Administrative',
'iso2' => '15'
],[
'country_id' => 174,
'name' => 'Antique',
'iso2' => 'ANT'
],[
'country_id' => 174,
'name' => 'Albay',
'iso2' => 'ALB'
],[
'country_id' => 174,
'name' => 'Masbate',
'iso2' => 'MAS'
],[
'country_id' => 174,
'name' => 'Northern Mindanao',
'iso2' => '10'
],[
'country_id' => 174,
'name' => 'Davao',
'iso2' => '11'
],[
'country_id' => 174,
'name' => 'Aurora',
'iso2' => 'AUR'
],[
'country_id' => 174,
'name' => 'Cagayan Valley',
'iso2' => '02'
],[
'country_id' => 174,
'name' => 'Misamis Occidental',
'iso2' => 'MSC'
],[
'country_id' => 174,
'name' => 'Bataan',
'iso2' => 'BAN'
],[
'country_id' => 174,
'name' => 'Central Luzon',
'iso2' => '03'
],[
'country_id' => 174,
'name' => 'Basilan',
'iso2' => 'BAS'
],[
'country_id' => 174,
'name' => 'Metro Manila',
'iso2' => 'NCR'
],[
'country_id' => 174,
'name' => 'Misamis Oriental',
'iso2' => 'MSR'
],[
'country_id' => 174,
'name' => 'Northern Samar',
'iso2' => 'NSA'
],[
'country_id' => 174,
'name' => 'Negros Oriental',
'iso2' => 'NER'
],[
'country_id' => 174,
'name' => 'Negros Occidental',
'iso2' => 'NEC'
],[
'country_id' => 174,
'name' => 'Batanes',
'iso2' => 'BTN'
],[
'country_id' => 174,
'name' => 'Mountain Province',
'iso2' => 'MOU'
],[
'country_id' => 174,
'name' => 'Oriental Mindoro',
'iso2' => 'MDR'
],[
'country_id' => 174,
'name' => 'Ilocos',
'iso2' => '01'
],[
'country_id' => 174,
'name' => 'Occidental Mindoro',
'iso2' => 'MDC'
],[
'country_id' => 174,
'name' => 'Zamboanga del Sur',
'iso2' => 'ZAS'
],[
'country_id' => 174,
'name' => 'Nueva Vizcaya',
'iso2' => 'NUV'
],[
'country_id' => 174,
'name' => 'Batangas',
'iso2' => 'BTG'
],[
'country_id' => 174,
'name' => 'Nueva Ecija',
'iso2' => 'NUE'
],[
'country_id' => 174,
'name' => 'Palawan',
'iso2' => 'PLW'
],[
'country_id' => 174,
'name' => 'Zamboanga Sibugay',
'iso2' => 'ZSI'
],[
'country_id' => 174,
'name' => 'Benguet',
'iso2' => 'BEN'
],[
'country_id' => 174,
'name' => 'Pangasinan',
'iso2' => 'PAN'
],[
'country_id' => 174,
'name' => 'Pampanga',
'iso2' => 'PAM'
],[
'country_id' => 174,
'name' => 'Western Samar',
'iso2' => 'WSA'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
