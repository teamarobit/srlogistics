<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class ETStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 70,
'name' => 'Southern Nations, Nationalities, and Peoples Region',
'iso2' => 'SN'
],[
'country_id' => 70,
'name' => 'Somali Region',
'iso2' => 'SO'
],[
'country_id' => 70,
'name' => 'Amhara Region',
'iso2' => 'AM'
],[
'country_id' => 70,
'name' => 'Tigray Region',
'iso2' => 'TI'
],[
'country_id' => 70,
'name' => 'Oromia Region',
'iso2' => 'OR'
],[
'country_id' => 70,
'name' => 'Afar Region',
'iso2' => 'AF'
],[
'country_id' => 70,
'name' => 'Harari Region',
'iso2' => 'HA'
],[
'country_id' => 70,
'name' => 'Dire Dawa',
'iso2' => 'DD'
],[
'country_id' => 70,
'name' => 'Benishangul-Gumuz Region',
'iso2' => 'BE'
],[
'country_id' => 70,
'name' => 'Gambela Region',
'iso2' => 'GA'
],[
'country_id' => 70,
'name' => 'Addis Ababa',
'iso2' => 'AA'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
