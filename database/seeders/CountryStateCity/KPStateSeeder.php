<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class KPStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 115,
'name' => 'North Hamgyong Province',
'iso2' => '09'
],[
'country_id' => 115,
'name' => 'Ryanggang Province',
'iso2' => '10'
],[
'country_id' => 115,
'name' => 'South Pyongan Province',
'iso2' => '02'
],[
'country_id' => 115,
'name' => 'Chagang Province',
'iso2' => '04'
],[
'country_id' => 115,
'name' => 'Kangwon Province',
'iso2' => '07'
],[
'country_id' => 115,
'name' => 'South Hamgyong Province',
'iso2' => '08'
],[
'country_id' => 115,
'name' => 'Rason',
'iso2' => '13'
],[
'country_id' => 115,
'name' => 'North Pyongan Province',
'iso2' => '03'
],[
'country_id' => 115,
'name' => 'South Hwanghae Province',
'iso2' => '05'
],[
'country_id' => 115,
'name' => 'North Hwanghae Province',
'iso2' => '06'
],[
'country_id' => 115,
'name' => 'Pyongyang',
'iso2' => '01'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
