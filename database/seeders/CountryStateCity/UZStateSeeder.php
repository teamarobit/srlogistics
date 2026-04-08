<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class UZStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 236,
'name' => 'Tashkent',
'iso2' => 'TK'
],[
'country_id' => 236,
'name' => 'Namangan Region',
'iso2' => 'NG'
],[
'country_id' => 236,
'name' => 'Fergana Region',
'iso2' => 'FA'
],[
'country_id' => 236,
'name' => 'Xorazm Region',
'iso2' => 'XO'
],[
'country_id' => 236,
'name' => 'Andijan Region',
'iso2' => 'AN'
],[
'country_id' => 236,
'name' => 'Bukhara Region',
'iso2' => 'BU'
],[
'country_id' => 236,
'name' => 'Navoiy Region',
'iso2' => 'NW'
],[
'country_id' => 236,
'name' => 'Qashqadaryo Region',
'iso2' => 'QA'
],[
'country_id' => 236,
'name' => 'Samarqand Region',
'iso2' => 'SA'
],[
'country_id' => 236,
'name' => 'Jizzakh Region',
'iso2' => 'JI'
],[
'country_id' => 236,
'name' => 'Surxondaryo Region',
'iso2' => 'SU'
],[
'country_id' => 236,
'name' => 'Sirdaryo Region',
'iso2' => 'SI'
],[
'country_id' => 236,
'name' => 'Karakalpakstan',
'iso2' => 'QR'
],[
'country_id' => 236,
'name' => 'Tashkent Region',
'iso2' => 'TO'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
