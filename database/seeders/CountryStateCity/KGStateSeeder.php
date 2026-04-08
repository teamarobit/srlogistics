<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class KGStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 118,
'name' => 'Talas Region',
'iso2' => 'T'
],[
'country_id' => 118,
'name' => 'Batken Region',
'iso2' => 'B'
],[
'country_id' => 118,
'name' => 'Naryn Region',
'iso2' => 'N'
],[
'country_id' => 118,
'name' => 'Jalal-Abad Region',
'iso2' => 'J'
],[
'country_id' => 118,
'name' => 'Bishkek',
'iso2' => 'GB'
],[
'country_id' => 118,
'name' => 'Issyk-Kul Region',
'iso2' => 'Y'
],[
'country_id' => 118,
'name' => 'Osh',
'iso2' => 'GO'
],[
'country_id' => 118,
'name' => 'Chuy Region',
'iso2' => 'C'
],[
'country_id' => 118,
'name' => 'Osh Region',
'iso2' => 'O'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
