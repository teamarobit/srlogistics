<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class ERStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 68,
'name' => 'Northern Red Sea Region',
'iso2' => 'SK'
],[
'country_id' => 68,
'name' => 'Anseba Region',
'iso2' => 'AN'
],[
'country_id' => 68,
'name' => 'Maekel Region',
'iso2' => 'MA'
],[
'country_id' => 68,
'name' => 'Debub Region',
'iso2' => 'DU'
],[
'country_id' => 68,
'name' => 'Gash-Barka Region',
'iso2' => 'GB'
],[
'country_id' => 68,
'name' => 'Southern Red Sea Region',
'iso2' => 'DK'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
