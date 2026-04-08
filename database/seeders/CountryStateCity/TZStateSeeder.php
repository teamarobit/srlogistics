<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class TZStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 218,
'name' => 'Shinyanga',
'iso2' => '22'
],[
'country_id' => 218,
'name' => 'Simiyu',
'iso2' => '30'
],[
'country_id' => 218,
'name' => 'Kagera',
'iso2' => '05'
],[
'country_id' => 218,
'name' => 'Dodoma',
'iso2' => '03'
],[
'country_id' => 218,
'name' => 'Kilimanjaro',
'iso2' => '09'
],[
'country_id' => 218,
'name' => 'Mara',
'iso2' => '13'
],[
'country_id' => 218,
'name' => 'Tabora',
'iso2' => '24'
],[
'country_id' => 218,
'name' => 'Morogoro',
'iso2' => '16'
],[
'country_id' => 218,
'name' => 'Zanzibar South',
'iso2' => '11'
],[
'country_id' => 218,
'name' => 'Pemba South',
'iso2' => '10'
],[
'country_id' => 218,
'name' => 'Zanzibar North',
'iso2' => '07'
],[
'country_id' => 218,
'name' => 'Singida',
'iso2' => '23'
],[
'country_id' => 218,
'name' => 'Zanzibar West',
'iso2' => '15'
],[
'country_id' => 218,
'name' => 'Mtwara',
'iso2' => '17'
],[
'country_id' => 218,
'name' => 'Rukwa',
'iso2' => '20'
],[
'country_id' => 218,
'name' => 'Kigoma',
'iso2' => '08'
],[
'country_id' => 218,
'name' => 'Mwanza',
'iso2' => '18'
],[
'country_id' => 218,
'name' => 'Njombe',
'iso2' => '29'
],[
'country_id' => 218,
'name' => 'Geita',
'iso2' => '27'
],[
'country_id' => 218,
'name' => 'Katavi',
'iso2' => '28'
],[
'country_id' => 218,
'name' => 'Lindi',
'iso2' => '12'
],[
'country_id' => 218,
'name' => 'Manyara',
'iso2' => '26'
],[
'country_id' => 218,
'name' => 'Pwani',
'iso2' => '19'
],[
'country_id' => 218,
'name' => 'Ruvuma',
'iso2' => '21'
],[
'country_id' => 218,
'name' => 'Tanga',
'iso2' => '25'
],[
'country_id' => 218,
'name' => 'Pemba North',
'iso2' => '06'
],[
'country_id' => 218,
'name' => 'Iringa',
'iso2' => '04'
],[
'country_id' => 218,
'name' => 'Dar es Salaam',
'iso2' => '02'
],[
'country_id' => 218,
'name' => 'Arusha',
'iso2' => '01'
],[
'country_id' => 218,
'name' => 'Mbeya',
'iso2' => '14'
],[
'country_id' => 218,
'name' => 'Songwe',
'iso2' => '31'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
