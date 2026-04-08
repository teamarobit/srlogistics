<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class SMStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 192,
'name' => 'San Marino',
'iso2' => '07'
],[
'country_id' => 192,
'name' => 'Acquaviva',
'iso2' => '01'
],[
'country_id' => 192,
'name' => 'Chiesanuova',
'iso2' => '02'
],[
'country_id' => 192,
'name' => 'Borgo Maggiore',
'iso2' => '06'
],[
'country_id' => 192,
'name' => 'Faetano',
'iso2' => '04'
],[
'country_id' => 192,
'name' => 'Montegiardino',
'iso2' => '08'
],[
'country_id' => 192,
'name' => 'Domagnano',
'iso2' => '03'
],[
'country_id' => 192,
'name' => 'Serravalle',
'iso2' => '09'
],[
'country_id' => 192,
'name' => 'Fiorentino',
'iso2' => '05'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
