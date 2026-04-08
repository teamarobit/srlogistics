<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class KWStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 117,
'name' => 'Al Jahra',
'iso2' => 'JA'
],[
'country_id' => 117,
'name' => 'Hawalli',
'iso2' => 'HA'
],[
'country_id' => 117,
'name' => 'Mubarak Al-Kabeer',
'iso2' => 'MU'
],[
'country_id' => 117,
'name' => 'Al Farwaniyah',
'iso2' => 'FA'
],[
'country_id' => 117,
'name' => 'Capital',
'iso2' => 'KU'
],[
'country_id' => 117,
'name' => 'Al Ahmadi',
'iso2' => 'AH'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
