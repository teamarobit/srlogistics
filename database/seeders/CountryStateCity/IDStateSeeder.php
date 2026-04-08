<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class IDStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 102,
'name' => 'Sumatera Utara',
'iso2' => 'SU'
],[
'country_id' => 102,
'name' => 'Bengkulu',
'iso2' => 'BE'
],[
'country_id' => 102,
'name' => 'Kalimantan Tengah',
'iso2' => 'KT'
],[
'country_id' => 102,
'name' => 'Sulawesi Selatan',
'iso2' => 'SN'
],[
'country_id' => 102,
'name' => 'Sulawesi Tenggara',
'iso2' => 'SG'
],[
'country_id' => 102,
'name' => 'Papua',
'iso2' => 'PA'
],[
'country_id' => 102,
'name' => 'Papua Barat',
'iso2' => 'PB'
],[
'country_id' => 102,
'name' => 'Maluku',
'iso2' => 'MA'
],[
'country_id' => 102,
'name' => 'Maluku Utara',
'iso2' => 'MU'
],[
'country_id' => 102,
'name' => 'Jawa Tengah',
'iso2' => 'JT'
],[
'country_id' => 102,
'name' => 'Kalimantan Timur',
'iso2' => 'KI'
],[
'country_id' => 102,
'name' => 'DKI Jakarta',
'iso2' => 'JK'
],[
'country_id' => 102,
'name' => 'Kalimantan Barat',
'iso2' => 'KB'
],[
'country_id' => 102,
'name' => 'Kepulauan Riau',
'iso2' => 'KR'
],[
'country_id' => 102,
'name' => 'Sulawesi Utara',
'iso2' => 'SA'
],[
'country_id' => 102,
'name' => 'Riau',
'iso2' => 'RI'
],[
'country_id' => 102,
'name' => 'Banten',
'iso2' => 'BT'
],[
'country_id' => 102,
'name' => 'Lampung',
'iso2' => 'LA'
],[
'country_id' => 102,
'name' => 'Gorontalo',
'iso2' => 'GO'
],[
'country_id' => 102,
'name' => 'Sulawesi Tengah',
'iso2' => 'ST'
],[
'country_id' => 102,
'name' => 'Nusa Tenggara Barat',
'iso2' => 'NB'
],[
'country_id' => 102,
'name' => 'Jambi',
'iso2' => 'JA'
],[
'country_id' => 102,
'name' => 'Sumatera Selatan',
'iso2' => 'SS'
],[
'country_id' => 102,
'name' => 'Sulawesi Barat',
'iso2' => 'SR'
],[
'country_id' => 102,
'name' => 'Nusa Tenggara Timur',
'iso2' => 'NT'
],[
'country_id' => 102,
'name' => 'Kalimantan Selatan',
'iso2' => 'KS'
],[
'country_id' => 102,
'name' => 'Kepulauan Bangka Belitung',
'iso2' => 'BB'
],[
'country_id' => 102,
'name' => 'Aceh',
'iso2' => 'AC'
],[
'country_id' => 102,
'name' => 'Kalimantan Utara',
'iso2' => 'KU'
],[
'country_id' => 102,
'name' => 'Jawa Barat',
'iso2' => 'JB'
],[
'country_id' => 102,
'name' => 'Bali',
'iso2' => 'BA'
],[
'country_id' => 102,
'name' => 'Jawa Timur',
'iso2' => 'JI'
],[
'country_id' => 102,
'name' => 'Sumatera Barat',
'iso2' => 'SB'
],[
'country_id' => 102,
'name' => 'DI Yogyakarta',
'iso2' => 'YO'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
