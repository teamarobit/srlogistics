<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class MRStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 139,
'name' => 'Hodh Ech Chargui',
'iso2' => '01'
],[
'country_id' => 139,
'name' => 'Brakna',
'iso2' => '05'
],[
'country_id' => 139,
'name' => 'Tiris Zemmour',
'iso2' => '11'
],[
'country_id' => 139,
'name' => 'Gorgol',
'iso2' => '04'
],[
'country_id' => 139,
'name' => 'Inchiri',
'iso2' => '12'
],[
'country_id' => 139,
'name' => 'Nouakchott-Nord',
'iso2' => '14'
],[
'country_id' => 139,
'name' => 'Adrar',
'iso2' => '07'
],[
'country_id' => 139,
'name' => 'Tagant',
'iso2' => '09'
],[
'country_id' => 139,
'name' => 'Dakhlet Nouadhibou',
'iso2' => '08'
],[
'country_id' => 139,
'name' => 'Nouakchott-Sud',
'iso2' => '15'
],[
'country_id' => 139,
'name' => 'Trarza',
'iso2' => '06'
],[
'country_id' => 139,
'name' => 'Assaba',
'iso2' => '03'
],[
'country_id' => 139,
'name' => 'Guidimaka',
'iso2' => '10'
],[
'country_id' => 139,
'name' => 'Hodh El Gharbi',
'iso2' => '02'
],[
'country_id' => 139,
'name' => 'Nouakchott-Ouest',
'iso2' => '13'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
