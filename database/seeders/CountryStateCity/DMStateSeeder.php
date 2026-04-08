<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class DMStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 61,
'name' => 'Saint John Parish',
'iso2' => '05'
],[
'country_id' => 61,
'name' => 'Saint Mark Parish',
'iso2' => '08'
],[
'country_id' => 61,
'name' => 'Saint David Parish',
'iso2' => '03'
],[
'country_id' => 61,
'name' => 'Saint George Parish',
'iso2' => '04'
],[
'country_id' => 61,
'name' => 'Saint Patrick Parish',
'iso2' => '09'
],[
'country_id' => 61,
'name' => 'Saint Peter Parish',
'iso2' => '11'
],[
'country_id' => 61,
'name' => 'Saint Andrew Parish',
'iso2' => '02'
],[
'country_id' => 61,
'name' => 'Saint Luke Parish',
'iso2' => '07'
],[
'country_id' => 61,
'name' => 'Saint Paul Parish',
'iso2' => '10'
],[
'country_id' => 61,
'name' => 'Saint Joseph Parish',
'iso2' => '06'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
