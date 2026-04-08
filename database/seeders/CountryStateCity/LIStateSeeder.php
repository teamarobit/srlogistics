<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class LIStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 125,
'name' => 'Schellenberg',
'iso2' => '08'
],[
'country_id' => 125,
'name' => 'Schaan',
'iso2' => '07'
],[
'country_id' => 125,
'name' => 'Eschen',
'iso2' => '02'
],[
'country_id' => 125,
'name' => 'Vaduz',
'iso2' => '11'
],[
'country_id' => 125,
'name' => 'Ruggell',
'iso2' => '06'
],[
'country_id' => 125,
'name' => 'Planken',
'iso2' => '05'
],[
'country_id' => 125,
'name' => 'Mauren',
'iso2' => '04'
],[
'country_id' => 125,
'name' => 'Triesenberg',
'iso2' => '10'
],[
'country_id' => 125,
'name' => 'Gamprin',
'iso2' => '03'
],[
'country_id' => 125,
'name' => 'Balzers',
'iso2' => '01'
],[
'country_id' => 125,
'name' => 'Triesen',
'iso2' => '09'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
