<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateSHRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1178,
'name' => '10th of Ramadan'
],[
'state_id' => 1178,
'name' => 'Markaz Abū Ḩammād'
],[
'state_id' => 1178,
'name' => 'Awlad Saqr'
],[
'state_id' => 1178,
'name' => 'Bilbeis'
],[
'state_id' => 1178,
'name' => 'Diyarb Negm'
],[
'state_id' => 1178,
'name' => 'El Husseiniya'
],[
'state_id' => 1178,
'name' => 'Al Qurein'
],[
'state_id' => 1178,
'name' => 'Faqous'
],[
'state_id' => 1178,
'name' => 'Hihya'
],[
'state_id' => 1178,
'name' => 'Kafr Saqr'
],[
'state_id' => 1178,
'name' => 'Mashtoul El Souk'
],[
'state_id' => 1178,
'name' => 'Minya El Qamh'
],[
'state_id' => 1178,
'name' => 'New Salhia'
],[
'state_id' => 1178,
'name' => 'Zagazig'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
