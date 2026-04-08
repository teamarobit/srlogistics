<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class CAStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 39,
'name' => 'Ontario',
'iso2' => 'ON'
],[
'country_id' => 39,
'name' => 'Manitoba',
'iso2' => 'MB'
],[
'country_id' => 39,
'name' => 'New Brunswick',
'iso2' => 'NB'
],[
'country_id' => 39,
'name' => 'Yukon',
'iso2' => 'YT'
],[
'country_id' => 39,
'name' => 'Saskatchewan',
'iso2' => 'SK'
],[
'country_id' => 39,
'name' => 'Prince Edward Island',
'iso2' => 'PE'
],[
'country_id' => 39,
'name' => 'Alberta',
'iso2' => 'AB'
],[
'country_id' => 39,
'name' => 'Quebec',
'iso2' => 'QC'
],[
'country_id' => 39,
'name' => 'Nova Scotia',
'iso2' => 'NS'
],[
'country_id' => 39,
'name' => 'British Columbia',
'iso2' => 'BC'
],[
'country_id' => 39,
'name' => 'Nunavut',
'iso2' => 'NU'
],[
'country_id' => 39,
'name' => 'Newfoundland and Labrador',
'iso2' => 'NL'
],[
'country_id' => 39,
'name' => 'Northwest Territories',
'iso2' => 'NT'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
