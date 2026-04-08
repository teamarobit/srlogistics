<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class CIStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 54,
'name' => 'Savanes Region',
'iso2' => '03'
],[
'country_id' => 54,
'name' => 'Agnéby',
'iso2' => '16'
],[
'country_id' => 54,
'name' => 'Lagunes District',
'iso2' => 'LG'
],[
'country_id' => 54,
'name' => 'Sud-Bandama',
'iso2' => '15'
],[
'country_id' => 54,
'name' => 'Montagnes District',
'iso2' => 'MG'
],[
'country_id' => 54,
'name' => 'Moyen-Comoé',
'iso2' => '05'
],[
'country_id' => 54,
'name' => 'Marahoué Region',
'iso2' => '12'
],[
'country_id' => 54,
'name' => 'Lacs District',
'iso2' => 'LC'
],[
'country_id' => 54,
'name' => 'Fromager',
'iso2' => '18'
],[
'country_id' => 54,
'name' => 'Abidjan',
'iso2' => 'AB'
],[
'country_id' => 54,
'name' => 'Bas-Sassandra Region',
'iso2' => '09'
],[
'country_id' => 54,
'name' => 'Bafing Region',
'iso2' => '17'
],[
'country_id' => 54,
'name' => 'Vallée du Bandama District',
'iso2' => 'VB'
],[
'country_id' => 54,
'name' => 'Haut-Sassandra',
'iso2' => '02'
],[
'country_id' => 54,
'name' => 'Lagunes region',
'iso2' => '01'
],[
'country_id' => 54,
'name' => 'Lacs Region',
'iso2' => '07'
],[
'country_id' => 54,
'name' => 'Zanzan Region',
'iso2' => 'ZZ'
],[
'country_id' => 54,
'name' => 'Denguélé Region',
'iso2' => '10'
],[
'country_id' => 54,
'name' => 'Bas-Sassandra District',
'iso2' => 'BS'
],[
'country_id' => 54,
'name' => 'Denguélé District',
'iso2' => 'DN'
],[
'country_id' => 54,
'name' => 'Dix-Huit Montagnes',
'iso2' => '06'
],[
'country_id' => 54,
'name' => 'Moyen-Cavally',
'iso2' => '19'
],[
'country_id' => 54,
'name' => 'Vallée du Bandama Region',
'iso2' => '04'
],[
'country_id' => 54,
'name' => 'Sassandra-Marahoué District',
'iso2' => 'SM'
],[
'country_id' => 54,
'name' => 'Worodougou',
'iso2' => '14'
],[
'country_id' => 54,
'name' => 'Woroba District',
'iso2' => 'WR'
],[
'country_id' => 54,
'name' => 'Gôh-Djiboua District',
'iso2' => 'GD'
],[
'country_id' => 54,
'name' => 'Sud-Comoé',
'iso2' => '13'
],[
'country_id' => 54,
'name' => 'Yamoussoukro',
'iso2' => 'YM'
],[
'country_id' => 54,
'name' => 'Comoé District',
'iso2' => 'CM'
],[
'country_id' => 54,
'name' => 'N zi-Comoé',
'iso2' => '11'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
