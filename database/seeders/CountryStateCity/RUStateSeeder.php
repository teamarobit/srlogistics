<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class RUStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 182,
'name' => 'Primorsky Krai',
'iso2' => 'PRI'
],[
'country_id' => 182,
'name' => 'Novgorod Oblast',
'iso2' => 'NGR'
],[
'country_id' => 182,
'name' => 'Jewish Autonomous Oblast',
'iso2' => 'YEV'
],[
'country_id' => 182,
'name' => 'Nenets Autonomous Okrug',
'iso2' => 'NEN'
],[
'country_id' => 182,
'name' => 'Rostov Oblast',
'iso2' => 'ROS'
],[
'country_id' => 182,
'name' => 'Khanty-Mansi Autonomous Okrug',
'iso2' => 'KHM'
],[
'country_id' => 182,
'name' => 'Magadan Oblast',
'iso2' => 'MAG'
],[
'country_id' => 182,
'name' => 'Krasnoyarsk Krai',
'iso2' => 'KYA'
],[
'country_id' => 182,
'name' => 'Republic of Karelia',
'iso2' => 'KR'
],[
'country_id' => 182,
'name' => 'Republic of Buryatia',
'iso2' => 'BU'
],[
'country_id' => 182,
'name' => 'Murmansk Oblast',
'iso2' => 'MUR'
],[
'country_id' => 182,
'name' => 'Kaluga Oblast',
'iso2' => 'KLU'
],[
'country_id' => 182,
'name' => 'Chelyabinsk Oblast',
'iso2' => 'CHE'
],[
'country_id' => 182,
'name' => 'Omsk Oblast',
'iso2' => 'OMS'
],[
'country_id' => 182,
'name' => 'Yamalo-Nenets Autonomous Okrug',
'iso2' => 'YAN'
],[
'country_id' => 182,
'name' => 'Sakha Republic',
'iso2' => 'SA'
],[
'country_id' => 182,
'name' => 'Arkhangelsk',
'iso2' => 'ARK'
],[
'country_id' => 182,
'name' => 'Republic of Dagestan',
'iso2' => 'DA'
],[
'country_id' => 182,
'name' => 'Yaroslavl Oblast',
'iso2' => 'YAR'
],[
'country_id' => 182,
'name' => 'Republic of Adygea',
'iso2' => 'AD'
],[
'country_id' => 182,
'name' => 'Republic of North Ossetia-Alania',
'iso2' => 'SE'
],[
'country_id' => 182,
'name' => 'Republic of Bashkortostan',
'iso2' => 'BA'
],[
'country_id' => 182,
'name' => 'Kursk Oblast',
'iso2' => 'KRS'
],[
'country_id' => 182,
'name' => 'Ulyanovsk Oblast',
'iso2' => 'ULY'
],[
'country_id' => 182,
'name' => 'Nizhny Novgorod Oblast',
'iso2' => 'NIZ'
],[
'country_id' => 182,
'name' => 'Amur Oblast',
'iso2' => 'AMU'
],[
'country_id' => 182,
'name' => 'Chukotka Autonomous Okrug',
'iso2' => 'CHU'
],[
'country_id' => 182,
'name' => 'Tver Oblast',
'iso2' => 'TVE'
],[
'country_id' => 182,
'name' => 'Republic of Tatarstan',
'iso2' => 'TA'
],[
'country_id' => 182,
'name' => 'Samara Oblast',
'iso2' => 'SAM'
],[
'country_id' => 182,
'name' => 'Pskov Oblast',
'iso2' => 'PSK'
],[
'country_id' => 182,
'name' => 'Ivanovo Oblast',
'iso2' => 'IVA'
],[
'country_id' => 182,
'name' => 'Kamchatka Krai',
'iso2' => 'KAM'
],[
'country_id' => 182,
'name' => 'Astrakhan Oblast',
'iso2' => 'AST'
],[
'country_id' => 182,
'name' => 'Bryansk Oblast',
'iso2' => 'BRY'
],[
'country_id' => 182,
'name' => 'Stavropol Krai',
'iso2' => 'STA'
],[
'country_id' => 182,
'name' => 'Karachay-Cherkess Republic',
'iso2' => 'KC'
],[
'country_id' => 182,
'name' => 'Mari El Republic',
'iso2' => 'ME'
],[
'country_id' => 182,
'name' => 'Perm Krai',
'iso2' => 'PER'
],[
'country_id' => 182,
'name' => 'Tomsk Oblast',
'iso2' => 'TOM'
],[
'country_id' => 182,
'name' => 'Khabarovsk Krai',
'iso2' => 'KHA'
],[
'country_id' => 182,
'name' => 'Vologda Oblast',
'iso2' => 'VLG'
],[
'country_id' => 182,
'name' => 'Sakhalin',
'iso2' => 'SAK'
],[
'country_id' => 182,
'name' => 'Altai Republic',
'iso2' => 'AL'
],[
'country_id' => 182,
'name' => 'Republic of Khakassia',
'iso2' => 'KK'
],[
'country_id' => 182,
'name' => 'Tambov Oblast',
'iso2' => 'TAM'
],[
'country_id' => 182,
'name' => 'Saint Petersburg',
'iso2' => 'SPE'
],[
'country_id' => 182,
'name' => 'Irkutsk',
'iso2' => 'IRK'
],[
'country_id' => 182,
'name' => 'Vladimir Oblast',
'iso2' => 'VLA'
],[
'country_id' => 182,
'name' => 'Moscow Oblast',
'iso2' => 'MOS'
],[
'country_id' => 182,
'name' => 'Republic of Kalmykia',
'iso2' => 'KL'
],[
'country_id' => 182,
'name' => 'Republic of Ingushetia',
'iso2' => 'IN'
],[
'country_id' => 182,
'name' => 'Smolensk Oblast',
'iso2' => 'SMO'
],[
'country_id' => 182,
'name' => 'Orenburg Oblast',
'iso2' => 'ORE'
],[
'country_id' => 182,
'name' => 'Saratov Oblast',
'iso2' => 'SAR'
],[
'country_id' => 182,
'name' => 'Novosibirsk',
'iso2' => 'NVS'
],[
'country_id' => 182,
'name' => 'Lipetsk Oblast',
'iso2' => 'LIP'
],[
'country_id' => 182,
'name' => 'Kirov Oblast',
'iso2' => 'KIR'
],[
'country_id' => 182,
'name' => 'Krasnodar Krai',
'iso2' => 'KDA'
],[
'country_id' => 182,
'name' => 'Kabardino-Balkar Republic',
'iso2' => 'KB'
],[
'country_id' => 182,
'name' => 'Chechen Republic',
'iso2' => 'CE'
],[
'country_id' => 182,
'name' => 'Sverdlovsk',
'iso2' => 'SVE'
],[
'country_id' => 182,
'name' => 'Tula Oblast',
'iso2' => 'TUL'
],[
'country_id' => 182,
'name' => 'Leningrad Oblast',
'iso2' => 'LEN'
],[
'country_id' => 182,
'name' => 'Kemerovo Oblast',
'iso2' => 'KEM'
],[
'country_id' => 182,
'name' => 'Republic of Mordovia',
'iso2' => 'MO'
],[
'country_id' => 182,
'name' => 'Komi Republic',
'iso2' => 'KO'
],[
'country_id' => 182,
'name' => 'Tuva Republic',
'iso2' => 'TY'
],[
'country_id' => 182,
'name' => 'Moscow',
'iso2' => 'MOW'
],[
'country_id' => 182,
'name' => 'Kaliningrad',
'iso2' => 'KGD'
],[
'country_id' => 182,
'name' => 'Belgorod Oblast',
'iso2' => 'BEL'
],[
'country_id' => 182,
'name' => 'Zabaykalsky Krai',
'iso2' => 'ZAB'
],[
'country_id' => 182,
'name' => 'Ryazan Oblast',
'iso2' => 'RYA'
],[
'country_id' => 182,
'name' => 'Voronezh Oblast',
'iso2' => 'VOR'
],[
'country_id' => 182,
'name' => 'Tyumen Oblast',
'iso2' => 'TYU'
],[
'country_id' => 182,
'name' => 'Oryol Oblast',
'iso2' => 'ORL'
],[
'country_id' => 182,
'name' => 'Penza Oblast',
'iso2' => 'PNZ'
],[
'country_id' => 182,
'name' => 'Kostroma Oblast',
'iso2' => 'KOS'
],[
'country_id' => 182,
'name' => 'Altai Krai',
'iso2' => 'ALT'
],[
'country_id' => 182,
'name' => 'Sevastopol',
'iso2' => 'UA-40'
],[
'country_id' => 182,
'name' => 'Udmurt Republic',
'iso2' => 'UD'
],[
'country_id' => 182,
'name' => 'Chuvash Republic',
'iso2' => 'CU'
],[
'country_id' => 182,
'name' => 'Kurgan Oblast',
'iso2' => 'KGN'
],[
'country_id' => 182,
'name' => 'Volgograd Oblast',
'iso2' => 'VGG'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
