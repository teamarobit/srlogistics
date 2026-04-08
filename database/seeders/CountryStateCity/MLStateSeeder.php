<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class MLStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 134,
'name' => 'Tombouctou Region',
'iso2' => '6'
],[
'country_id' => 134,
'name' => 'Ségou Region',
'iso2' => '4'
],[
'country_id' => 134,
'name' => 'Koulikoro Region',
'iso2' => '2'
],[
'country_id' => 134,
'name' => 'Ménaka Region',
'iso2' => '9'
],[
'country_id' => 134,
'name' => 'Kayes Region',
'iso2' => '1'
],[
'country_id' => 134,
'name' => 'Bamako',
'iso2' => 'BKO'
],[
'country_id' => 134,
'name' => 'Sikasso Region',
'iso2' => '3'
],[
'country_id' => 134,
'name' => 'Mopti Region',
'iso2' => '5'
],[
'country_id' => 134,
'name' => 'Taoudénit Region',
'iso2' => '10'
],[
'country_id' => 134,
'name' => 'Kidal Region',
'iso2' => '8'
],[
'country_id' => 134,
'name' => 'Gao Region',
'iso2' => '7'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
