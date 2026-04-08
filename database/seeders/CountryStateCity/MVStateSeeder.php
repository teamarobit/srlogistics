<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class MVStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 133,
'name' => 'Vaavu Atoll',
'iso2' => '04'
],[
'country_id' => 133,
'name' => 'Shaviyani Atoll',
'iso2' => '24'
],[
'country_id' => 133,
'name' => 'Haa Alif Atoll',
'iso2' => '07'
],[
'country_id' => 133,
'name' => 'Alif Alif Atoll',
'iso2' => '02'
],[
'country_id' => 133,
'name' => 'North Province',
'iso2' => 'NO'
],[
'country_id' => 133,
'name' => 'North Central Province',
'iso2' => 'NC'
],[
'country_id' => 133,
'name' => 'Dhaalu Atoll',
'iso2' => '17'
],[
'country_id' => 133,
'name' => 'Thaa Atoll',
'iso2' => '08'
],[
'country_id' => 133,
'name' => 'Noonu Atoll',
'iso2' => '25'
],[
'country_id' => 133,
'name' => 'Upper South Province',
'iso2' => 'US'
],[
'country_id' => 133,
'name' => 'Addu Atoll',
'iso2' => '01'
],[
'country_id' => 133,
'name' => 'Gnaviyani Atoll',
'iso2' => '29'
],[
'country_id' => 133,
'name' => 'Kaafu Atoll',
'iso2' => '26'
],[
'country_id' => 133,
'name' => 'Haa Dhaalu Atoll',
'iso2' => '23'
],[
'country_id' => 133,
'name' => 'Gaafu Alif Atoll',
'iso2' => '27'
],[
'country_id' => 133,
'name' => 'Faafu Atoll',
'iso2' => '14'
],[
'country_id' => 133,
'name' => 'Alif Dhaal Atoll',
'iso2' => '00'
],[
'country_id' => 133,
'name' => 'Laamu Atoll',
'iso2' => '05'
],[
'country_id' => 133,
'name' => 'Raa Atoll',
'iso2' => '13'
],[
'country_id' => 133,
'name' => 'Gaafu Dhaalu Atoll',
'iso2' => '28'
],[
'country_id' => 133,
'name' => 'Central Province',
'iso2' => 'CE'
],[
'country_id' => 133,
'name' => 'South Province',
'iso2' => 'SU'
],[
'country_id' => 133,
'name' => 'South Central Province',
'iso2' => 'SC'
],[
'country_id' => 133,
'name' => 'Lhaviyani Atoll',
'iso2' => '03'
],[
'country_id' => 133,
'name' => 'Meemu Atoll',
'iso2' => '12'
],[
'country_id' => 133,
'name' => 'Malé',
'iso2' => 'MLE'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
