<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EEState84CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1209,
'name' => 'Abja-Paluoja'
],[
'state_id' => 1209,
'name' => 'Karksi-Nuia'
],[
'state_id' => 1209,
'name' => 'Mõisaküla'
],[
'state_id' => 1209,
'name' => 'Suure-Jaani'
],[
'state_id' => 1209,
'name' => 'Viiratsi'
],[
'state_id' => 1209,
'name' => 'Viljandi'
],[
'state_id' => 1209,
'name' => 'Viljandi vald'
],[
'state_id' => 1209,
'name' => 'Võhma'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
