<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class NOStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 165,
'name' => 'Trøndelag',
'iso2' => '50'
],[
'country_id' => 165,
'name' => 'Oslo',
'iso2' => '03'
],[
'country_id' => 165,
'name' => 'Innlandet',
'iso2' => '34'
],[
'country_id' => 165,
'name' => 'Viken',
'iso2' => '30'
],[
'country_id' => 165,
'name' => 'Svalbard',
'iso2' => '21'
],[
'country_id' => 165,
'name' => 'Agder',
'iso2' => '42'
],[
'country_id' => 165,
'name' => 'Troms og Finnmark',
'iso2' => '54'
],[
'country_id' => 165,
'name' => 'Vestland',
'iso2' => '46'
],[
'country_id' => 165,
'name' => 'Møre og Romsdal',
'iso2' => '15'
],[
'country_id' => 165,
'name' => 'Rogaland',
'iso2' => '11'
],[
'country_id' => 165,
'name' => 'Vestfold og Telemark',
'iso2' => '38'
],[
'country_id' => 165,
'name' => 'Nordland',
'iso2' => '18'
],[
'country_id' => 165,
'name' => 'Jan Mayen',
'iso2' => '22'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
