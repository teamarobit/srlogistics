<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class SNStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 195,
'name' => 'Dakar',
'iso2' => 'DK'
],[
'country_id' => 195,
'name' => 'Kolda',
'iso2' => 'KD'
],[
'country_id' => 195,
'name' => 'Kaffrine',
'iso2' => 'KA'
],[
'country_id' => 195,
'name' => 'Matam',
'iso2' => 'MT'
],[
'country_id' => 195,
'name' => 'Saint-Louis',
'iso2' => 'SL'
],[
'country_id' => 195,
'name' => 'Ziguinchor',
'iso2' => 'ZG'
],[
'country_id' => 195,
'name' => 'Fatick',
'iso2' => 'FK'
],[
'country_id' => 195,
'name' => 'Diourbel Region',
'iso2' => 'DB'
],[
'country_id' => 195,
'name' => 'Kédougou',
'iso2' => 'KE'
],[
'country_id' => 195,
'name' => 'Sédhiou',
'iso2' => 'SE'
],[
'country_id' => 195,
'name' => 'Kaolack',
'iso2' => 'KL'
],[
'country_id' => 195,
'name' => 'Thiès Region',
'iso2' => 'TH'
],[
'country_id' => 195,
'name' => 'Louga',
'iso2' => 'LG'
],[
'country_id' => 195,
'name' => 'Tambacounda Region',
'iso2' => 'TC'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
