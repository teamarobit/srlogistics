<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class ALStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 3,
'name' => 'Skrapar District',
'iso2' => 'SK'
],[
'country_id' => 3,
'name' => 'Kavajë District',
'iso2' => 'KA'
],[
'country_id' => 3,
'name' => 'Lezhë District',
'iso2' => 'LE'
],[
'country_id' => 3,
'name' => 'Librazhd District',
'iso2' => 'LB'
],[
'country_id' => 3,
'name' => 'Korçë District',
'iso2' => 'KO'
],[
'country_id' => 3,
'name' => 'Elbasan County',
'iso2' => '03'
],[
'country_id' => 3,
'name' => 'Lushnjë District',
'iso2' => 'LU'
],[
'country_id' => 3,
'name' => 'Has District',
'iso2' => 'HA'
],[
'country_id' => 3,
'name' => 'Kukës County',
'iso2' => '07'
],[
'country_id' => 3,
'name' => 'Malësi e Madhe District',
'iso2' => 'MM'
],[
'country_id' => 3,
'name' => 'Berat County',
'iso2' => '01'
],[
'country_id' => 3,
'name' => 'Gjirokastër County',
'iso2' => '05'
],[
'country_id' => 3,
'name' => 'Dibër District',
'iso2' => 'DI'
],[
'country_id' => 3,
'name' => 'Pogradec District',
'iso2' => 'PG'
],[
'country_id' => 3,
'name' => 'Bulqizë District',
'iso2' => 'BU'
],[
'country_id' => 3,
'name' => 'Devoll District',
'iso2' => 'DV'
],[
'country_id' => 3,
'name' => 'Lezhë County',
'iso2' => '08'
],[
'country_id' => 3,
'name' => 'Dibër County',
'iso2' => '09'
],[
'country_id' => 3,
'name' => 'Shkodër County',
'iso2' => '10'
],[
'country_id' => 3,
'name' => 'Kuçovë District',
'iso2' => 'KC'
],[
'country_id' => 3,
'name' => 'Vlorë District',
'iso2' => 'VL'
],[
'country_id' => 3,
'name' => 'Krujë District',
'iso2' => 'KR'
],[
'country_id' => 3,
'name' => 'Tirana County',
'iso2' => '11'
],[
'country_id' => 3,
'name' => 'Tepelenë District',
'iso2' => 'TE'
],[
'country_id' => 3,
'name' => 'Gramsh District',
'iso2' => 'GR'
],[
'country_id' => 3,
'name' => 'Delvinë District',
'iso2' => 'DL'
],[
'country_id' => 3,
'name' => 'Peqin District',
'iso2' => 'PQ'
],[
'country_id' => 3,
'name' => 'Pukë District',
'iso2' => 'PU'
],[
'country_id' => 3,
'name' => 'Gjirokastër District',
'iso2' => 'GJ'
],[
'country_id' => 3,
'name' => 'Kurbin District',
'iso2' => 'KB'
],[
'country_id' => 3,
'name' => 'Kukës District',
'iso2' => 'KU'
],[
'country_id' => 3,
'name' => 'Sarandë District',
'iso2' => 'SR'
],[
'country_id' => 3,
'name' => 'Përmet District',
'iso2' => 'PR'
],[
'country_id' => 3,
'name' => 'Shkodër District',
'iso2' => 'SH'
],[
'country_id' => 3,
'name' => 'Fier District',
'iso2' => 'FR'
],[
'country_id' => 3,
'name' => 'Kolonjë District',
'iso2' => 'ER'
],[
'country_id' => 3,
'name' => 'Berat District',
'iso2' => 'BR'
],[
'country_id' => 3,
'name' => 'Korçë County',
'iso2' => '06'
],[
'country_id' => 3,
'name' => 'Fier County',
'iso2' => '04'
],[
'country_id' => 3,
'name' => 'Durrës County',
'iso2' => '02'
],[
'country_id' => 3,
'name' => 'Tirana District',
'iso2' => 'TR'
],[
'country_id' => 3,
'name' => 'Vlorë County',
'iso2' => '12'
],[
'country_id' => 3,
'name' => 'Mat District',
'iso2' => 'MT'
],[
'country_id' => 3,
'name' => 'Tropojë District',
'iso2' => 'TP'
],[
'country_id' => 3,
'name' => 'Mallakastër District',
'iso2' => 'MK'
],[
'country_id' => 3,
'name' => 'Mirditë District',
'iso2' => 'MR'
],[
'country_id' => 3,
'name' => 'Durrës District',
'iso2' => 'DR'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
