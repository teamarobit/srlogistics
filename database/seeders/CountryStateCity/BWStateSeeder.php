<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class BWStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 29,
'name' => 'Ngamiland',
'iso2' => 'NG'
],[
'country_id' => 29,
'name' => 'Ghanzi District',
'iso2' => 'GH'
],[
'country_id' => 29,
'name' => 'Kgatleng District',
'iso2' => 'KL'
],[
'country_id' => 29,
'name' => 'Southern District',
'iso2' => 'SO'
],[
'country_id' => 29,
'name' => 'South-East District',
'iso2' => 'SE'
],[
'country_id' => 29,
'name' => 'North-West District',
'iso2' => 'NW'
],[
'country_id' => 29,
'name' => 'Kgalagadi District',
'iso2' => 'KG'
],[
'country_id' => 29,
'name' => 'Central District',
'iso2' => 'CE'
],[
'country_id' => 29,
'name' => 'North-East District',
'iso2' => 'NE'
],[
'country_id' => 29,
'name' => 'Kweneng District',
'iso2' => 'KW'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
