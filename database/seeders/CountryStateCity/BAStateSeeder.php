<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class BAStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 28,
'name' => 'Brčko District',
'iso2' => 'BRC'
],[
'country_id' => 28,
'name' => 'Tuzla Canton',
'iso2' => '03'
],[
'country_id' => 28,
'name' => 'Central Bosnia Canton',
'iso2' => '06'
],[
'country_id' => 28,
'name' => 'Herzegovina-Neretva Canton',
'iso2' => '07'
],[
'country_id' => 28,
'name' => 'Posavina Canton',
'iso2' => '02'
],[
'country_id' => 28,
'name' => 'Una-Sana Canton',
'iso2' => '01'
],[
'country_id' => 28,
'name' => 'Sarajevo Canton',
'iso2' => '09'
],[
'country_id' => 28,
'name' => 'Federation of Bosnia and Herzegovina',
'iso2' => 'BIH'
],[
'country_id' => 28,
'name' => 'Zenica-Doboj Canton',
'iso2' => '04'
],[
'country_id' => 28,
'name' => 'West Herzegovina Canton',
'iso2' => '08'
],[
'country_id' => 28,
'name' => 'Republika Srpska',
'iso2' => 'SRP'
],[
'country_id' => 28,
'name' => 'Canton 10',
'iso2' => '10'
],[
'country_id' => 28,
'name' => 'Bosnian Podrinje Canton',
'iso2' => '05'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
