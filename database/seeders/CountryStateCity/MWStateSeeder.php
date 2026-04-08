<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class MWStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 131,
'name' => 'Machinga District',
'iso2' => 'MH'
],[
'country_id' => 131,
'name' => 'Zomba District',
'iso2' => 'ZO'
],[
'country_id' => 131,
'name' => 'Mwanza District',
'iso2' => 'MW'
],[
'country_id' => 131,
'name' => 'Nsanje District',
'iso2' => 'NS'
],[
'country_id' => 131,
'name' => 'Salima District',
'iso2' => 'SA'
],[
'country_id' => 131,
'name' => 'Chitipa district',
'iso2' => 'CT'
],[
'country_id' => 131,
'name' => 'Ntcheu District',
'iso2' => 'NU'
],[
'country_id' => 131,
'name' => 'Rumphi District',
'iso2' => 'RU'
],[
'country_id' => 131,
'name' => 'Dowa District',
'iso2' => 'DO'
],[
'country_id' => 131,
'name' => 'Karonga District',
'iso2' => 'KR'
],[
'country_id' => 131,
'name' => 'Central Region',
'iso2' => 'C'
],[
'country_id' => 131,
'name' => 'Likoma District',
'iso2' => 'LK'
],[
'country_id' => 131,
'name' => 'Kasungu District',
'iso2' => 'KS'
],[
'country_id' => 131,
'name' => 'Nkhata Bay District',
'iso2' => 'NB'
],[
'country_id' => 131,
'name' => 'Balaka District',
'iso2' => 'BA'
],[
'country_id' => 131,
'name' => 'Dedza District',
'iso2' => 'DE'
],[
'country_id' => 131,
'name' => 'Thyolo District',
'iso2' => 'TH'
],[
'country_id' => 131,
'name' => 'Mchinji District',
'iso2' => 'MC'
],[
'country_id' => 131,
'name' => 'Nkhotakota District',
'iso2' => 'NK'
],[
'country_id' => 131,
'name' => 'Lilongwe District',
'iso2' => 'LI'
],[
'country_id' => 131,
'name' => 'Blantyre District',
'iso2' => 'BL'
],[
'country_id' => 131,
'name' => 'Mulanje District',
'iso2' => 'MU'
],[
'country_id' => 131,
'name' => 'Mzimba District',
'iso2' => 'MZ'
],[
'country_id' => 131,
'name' => 'Northern Region',
'iso2' => 'N'
],[
'country_id' => 131,
'name' => 'Southern Region',
'iso2' => 'S'
],[
'country_id' => 131,
'name' => 'Chikwawa District',
'iso2' => 'CK'
],[
'country_id' => 131,
'name' => 'Phalombe District',
'iso2' => 'PH'
],[
'country_id' => 131,
'name' => 'Chiradzulu District',
'iso2' => 'CR'
],[
'country_id' => 131,
'name' => 'Mangochi District',
'iso2' => 'MG'
],[
'country_id' => 131,
'name' => 'Ntchisi District',
'iso2' => 'NI'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
