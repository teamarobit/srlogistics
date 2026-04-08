<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class MEStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 147,
'name' => 'Petnjica Municipality',
'iso2' => '23'
],[
'country_id' => 147,
'name' => 'Bar Municipality',
'iso2' => '02'
],[
'country_id' => 147,
'name' => 'Danilovgrad Municipality',
'iso2' => '07'
],[
'country_id' => 147,
'name' => 'Rožaje Municipality',
'iso2' => '17'
],[
'country_id' => 147,
'name' => 'Plužine Municipality',
'iso2' => '15'
],[
'country_id' => 147,
'name' => 'Nikšić Municipality',
'iso2' => '12'
],[
'country_id' => 147,
'name' => 'Šavnik Municipality',
'iso2' => '18'
],[
'country_id' => 147,
'name' => 'Plav Municipality',
'iso2' => '13'
],[
'country_id' => 147,
'name' => 'Pljevlja Municipality',
'iso2' => '14'
],[
'country_id' => 147,
'name' => 'Berane Municipality',
'iso2' => '03'
],[
'country_id' => 147,
'name' => 'Mojkovac Municipality',
'iso2' => '11'
],[
'country_id' => 147,
'name' => 'Andrijevica Municipality',
'iso2' => '01'
],[
'country_id' => 147,
'name' => 'Gusinje Municipality',
'iso2' => '22'
],[
'country_id' => 147,
'name' => 'Bijelo Polje Municipality',
'iso2' => '04'
],[
'country_id' => 147,
'name' => 'Kotor Municipality',
'iso2' => '10'
],[
'country_id' => 147,
'name' => 'Podgorica Municipality',
'iso2' => '16'
],[
'country_id' => 147,
'name' => 'Old Royal Capital Cetinje',
'iso2' => '06'
],[
'country_id' => 147,
'name' => 'Tivat Municipality',
'iso2' => '19'
],[
'country_id' => 147,
'name' => 'Budva Municipality',
'iso2' => '05'
],[
'country_id' => 147,
'name' => 'Kolašin Municipality',
'iso2' => '09'
],[
'country_id' => 147,
'name' => 'Žabljak Municipality',
'iso2' => '21'
],[
'country_id' => 147,
'name' => 'Ulcinj Municipality',
'iso2' => '20'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
